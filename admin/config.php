<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/../includes/functions.php';

$key = $_GET['key'] ?? '';
$token = $_GET['token'] ?? '';
$correct = 's3cr3tKy';
$salt = 'THU_S4LT_2024';

if ($key === '' || $token === '') {
    render_header('Admin Config', 'Time is a side channel. Math is a weapon.');
    ?>
    <section class="content-band two-col">
        <div class="panel">
            <h2>Gizli Konfigurasyon</h2>
            <p>Bu sayfa sadece gecerli <code>key</code> ve <code>token</code> ile tam acilir.</p>
            <p class="muted">Yanlis karakter ne kadar erken gelirse cevap o kadar hizli doner.</p>
        </div>
        <div class="panel">
            <h2>Dogrulama Formulu</h2>
            <pre class="code-block">token = md5(secret_salt + key)</pre>
        </div>
    </section>
    <?php
    render_footer();
    exit;
}

for ($i = 0; $i < strlen($key); $i++) {
    if (!isset($correct[$i]) || $key[$i] !== $correct[$i]) {
        http_response_code(403);
        exit('Erisim reddedildi.');
    }
    usleep(5000);
}

if (strlen($key) !== strlen($correct)) {
    http_response_code(403);
    exit('Anahtar uzunlugu hatali.');
}

$expected = md5($salt . $key);
if ($token === $expected) {
    render_header('Admin Config', 'Time is a side channel. Math is a weapon.');
    ?>
    <section class="content-band">
        <div class="panel">
            <h2>Konfigurasyon Acildi</h2>
            <ul class="terminal-list">
                <li>signing_mode = legacy-prefix-md5</li>
                <li>salt = <?= e($salt); ?></li>
                <li>operator_key = <?= e($correct); ?></li>
            </ul>
            <div class="flag-box">THU{t1m1ng_4tt4ck_h4sh_3xt3ns10n_g0d}</div>
        </div>
    </section>
    <?php
    render_footer();
    exit;
}

http_response_code(403);
exit('Token eslesmedi.');
