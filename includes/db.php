<?php
session_start();
error_reporting(0);

$config = require __DIR__ . '/config.php';

try {
    if (!empty($config['db_socket'])) {
        $dsn = sprintf(
            'mysql:unix_socket=%s;dbname=%s;charset=utf8mb4',
            $config['db_socket'],
            $config['db_name']
        );
    } else {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $config['db_host'],
            (int) ($config['db_port'] ?? 3306),
            $config['db_name']
        );
    }
    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    exit('Veritabani baglantisi kurulamadi.');
}
