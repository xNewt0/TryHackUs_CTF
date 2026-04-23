<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

$user = current_user($pdo);
if (!$user) {
    http_response_code(401);
    echo json_encode(['error' => 'Giris gerekli.']);
    exit;
}

if (!empty($_GET['avatar_url'])) {
    $target = $_GET['avatar_url'];
    $body = @file_get_contents($target);
    echo json_encode([
        'fetched_from' => $target,
        'response' => $body,
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' || ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'update')) {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!$data) {
        $data = $_POST;
    }

    if (!$data) {
        echo json_encode(['error' => 'Guncellenecek veri yok.']);
        exit;
    }

    $parts = [];
    foreach ($data as $field => $value) {
        $parts[] = $field . '=' . $pdo->quote($value);
    }

    $fields = implode(', ', $parts);
    $id = (int) $user['id'];
    $pdo->exec("UPDATE users SET $fields WHERE id=$id");

    if (isset($data['role'])) {
        $_SESSION['role'] = $data['role'];
    }
    if (isset($data['username'])) {
        $_SESSION['username'] = $data['username'];
    }

    echo json_encode([
        'status' => 'updated',
        'fields' => array_keys($data),
        'flag' => isset($data['role']) && $data['role'] === 'admin' ? 'THU{m4ss_4ss1gnm3nt_pr1v3sc}' : null,
    ]);
    exit;
}

$id = (int) ($_GET['id'] ?? $user['id']);
$stmt = $pdo->prepare('SELECT id, username, email, role, bio, token, created_at FROM users WHERE id = ? LIMIT 1');
$stmt->execute([$id]);
$targetUser = $stmt->fetch();

echo json_encode([
    'user' => $targetUser,
    'note' => 'Direct object references are fast, but not always safe.',
]);
