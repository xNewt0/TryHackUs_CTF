<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/../includes/functions.php';

if (empty($_SESSION['c2_access'])) {
    http_response_code(403);
    exit('C2 erisimi engellendi.');
}

render_header('C2 Dashboard', 'One vulnerability is never enough. Chain them all.');
?>
<section class="content-band two-col">
    <div class="panel">
        <h2>Operator Paneli</h2>
        <ul class="terminal-list">
            <li>Beacon count: 12</li>
            <li>Task queue: idle</li>
            <li>Channel: covert</li>
        </ul>
    </div>
    <div class="panel">
        <h2>C2 Flag</h2>
        <div class="flag-box">THU{ch41n3d_4tt4ck_m4st3r}</div>
        <p class="muted">Yetki XXE import oturumundan miras alindi.</p>
    </div>
</section>
<?php render_footer(); ?>
