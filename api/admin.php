<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

$user = current_user($pdo);
if (!$user) {
    http_response_code(401);
    echo json_encode(['error' => 'Kimlik dogrulama gerekli.']);
    exit;
}

$action = $_GET['action'] ?? 'info';

if ($action === 'get_flags') {
    $stmt = $pdo->query('SELECT id, flag_name, difficulty, description FROM flags ORDER BY id ASC');
    echo json_encode([
        'flag' => 'THU{br0k3n_4cc3ss_4dm1n_4p1}',
        'results' => $stmt->fetchAll(),
        'client_trust' => 'frontend_only',
    ]);
    exit;
}

if ($action === 'import') {
    $token = get_bearer_token() ?: ($_SESSION['jwt'] ?? '');
    $payload = $token ? decode_jwt($token) : null;
    $role = $payload['role'] ?? ($_SESSION['role'] ?? 'member');

    if ($role !== 'admin') {
        http_response_code(403);
        echo json_encode(['error' => 'Yalnizca admin import yapabilir.']);
        exit;
    }

    $xml = file_get_contents('php://input');
    $import = @simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOENT);

    if (!$import) {
        echo json_encode(['error' => 'XML parse edilemedi.']);
        exit;
    }

    $_SESSION['c2_access'] = true;

    echo json_encode([
        'imported' => (string) ($import->data ?? ''),
        'flag' => strpos($xml, '<!DOCTYPE') !== false ? 'THU{xxe_r34ds_l0c4l_f1l3s}' : null,
        'c2_access' => true,
    ]);
    exit;
}

echo json_encode([
    'status' => 'ok',
    'actions' => ['get_flags', 'import'],
]);
