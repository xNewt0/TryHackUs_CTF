<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

$token = get_bearer_token() ?: ($_SESSION['jwt'] ?? '');
$payload = $token ? decode_jwt($token) : null;

if (!$payload && empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Token gerekli.']);
    exit;
}

$role = $payload['role'] ?? ($_SESSION['role'] ?? 'member');
if ($role !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Bu endpoint admin token istiyor.']);
    exit;
}

echo json_encode([
    'flag' => 'THU{jwt_n0n3_4lg0_byp4ss}',
    'hint' => 'Algorithms can be negotiated in dangerous ways.',
]);
