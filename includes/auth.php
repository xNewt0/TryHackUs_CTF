<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/db.php';

function thu_base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function thu_base64url_decode($data)
{
    $padding = 4 - (strlen($data) % 4);
    if ($padding < 4) {
        $data .= str_repeat('=', $padding);
    }

    return base64_decode(strtr($data, '-_', '+/'));
}

function issue_jwt(array $user, PDO $pdo)
{
    $config = require __DIR__ . '/config.php';

    $header = thu_base64url_encode(json_encode([
        'alg' => 'HS256',
        'typ' => 'JWT',
    ]));

    $payload = thu_base64url_encode(json_encode([
        'id' => $user['id'],
        'username' => $user['username'],
        'role' => $user['role'],
        'exp' => time() + 86400,
    ]));

    $signature = thu_base64url_encode(hash_hmac('sha256', $header . '.' . $payload, $config['jwt_secret'], true));
    $token = $header . '.' . $payload . '.' . $signature;

    $stmt = $pdo->prepare('UPDATE users SET token = ? WHERE id = ?');
    $stmt->execute([$token, $user['id']]);

    return $token;
}

function decode_jwt($token)
{
    $config = require __DIR__ . '/config.php';
    $parts = explode('.', $token);

    if (count($parts) < 2) {
        return false;
    }

    $header = json_decode(thu_base64url_decode($parts[0]), true);
    $payload = json_decode(thu_base64url_decode($parts[1]), true);

    if (!$header || !$payload) {
        return false;
    }

    if (($header['alg'] ?? '') === 'none') {
        return $payload;
    }

    if (count($parts) !== 3) {
        return false;
    }

    $expected = thu_base64url_encode(hash_hmac('sha256', $parts[0] . '.' . $parts[1], $config['jwt_secret'], true));
    if (!hash_equals($expected, $parts[2])) {
        return false;
    }

    return $payload;
}

function get_bearer_token()
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$header && function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
        $header = $headers['Authorization'] ?? '';
    }

    if (stripos($header, 'Bearer ') === 0) {
        return trim(substr($header, 7));
    }

    return null;
}

function current_user(PDO $pdo)
{
    if (!empty($_SESSION['user_id'])) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }

    $token = get_bearer_token();
    if ($token) {
        $payload = decode_jwt($token);
        if ($payload && !empty($payload['id'])) {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
            $stmt->execute([$payload['id']]);
            $user = $stmt->fetch();
            if ($user) {
                return array_merge($user, ['token_payload' => $payload]);
            }
        }
    }

    return null;
}

function force_login()
{
    if (empty($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit;
    }
}

function force_admin(PDO $pdo)
{
    $user = current_user($pdo);
    if (!$user || ($user['role'] ?? 'member') !== 'admin') {
        header('Location: /dashboard.php');
        exit;
    }
}

function set_login_side_effects()
{
    setcookie('debug_token', base64_encode('THU{c00k13s_4r3_d3l1c10us}'), time() + 3600, '/');
}

function enable_admin_review_cookie()
{
    if (($_SESSION['role'] ?? '') === 'admin') {
        setcookie('admin_bot', 'THU{st0r3d_xss_p3rs1sts}', time() + 3600, '/');
    }
}
