<?php
session_start();
error_reporting(0);

return [
    'db_host' => '127.0.0.1',
    'db_port' => 3307,
    'db_socket' => '/tmp/thu_mysql.sock',
    'db_name' => 'tryhackus_ctf',
    'db_user' => 'root',
    'db_pass' => '',
    'jwt_secret' => 'thu_jwt_dev_secret',
    'base_url' => '',
];

// FLAG-10: THU{p4th_tr4v3rs4l_r34ds_4ll}
// FLAG-11: THU{upl04d_3x3c_rce_w1ns}
