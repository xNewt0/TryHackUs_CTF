<?php
session_start();
error_reporting(0);

$allowed = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
header('Content-Type: application/json; charset=utf-8');

if (!$allowed) {
    http_response_code(403);
    echo json_encode(['error' => 'Bu endpoint sadece dahili ag icin acik.']);
    exit;
}

echo json_encode([
    'service' => 'debug',
    'status' => 'internal',
    'flag' => 'THU{ssrf_1nt3rn4l_s3rv1c3s}',
    'c2_hint' => 'Encoded slashes around /c2/ survive longer than expected.',
]);
