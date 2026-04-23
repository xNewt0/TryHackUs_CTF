<?php
session_start();
error_reporting(0);

session_unset();
session_destroy();

setcookie('debug_token', '', time() - 3600, '/');
setcookie('admin_bot', '', time() - 3600, '/');

header('Location: /index.php');
exit;
