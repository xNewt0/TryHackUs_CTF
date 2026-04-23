<?php
session_start();
error_reporting(0);

$storage = [
    'beacon_master' => base64_encode('operator:nightlink'),
    'panel_flag' => base64_encode('THU{ch41n3d_4tt4ck_m4st3r}'),
    'import_flag' => base64_encode('THU{xxe_r34ds_l0c4l_f1l3s}'),
];

return $storage;
