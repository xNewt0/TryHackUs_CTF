<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

force_login();
header('X-Secret-Flag: THU{h34d3rs_t3ll_s3cr3ts}');

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

render_header('Kontrol Paneli', 'What does the server whisper in its headers?');
?>
<section class="content-band two-col">
    <article class="panel">
        <h2>Oturum Ozeti</h2>
        <ul class="terminal-list">
            <li>Kullanici: <?= e($user['username']); ?></li>
            <li>Rol: <?= e($user['role']); ?></li>
            <li>Oturum ID: <?= (int) $user['id']; ?></li>
            <li>JWT: <span class="break-all"><?= e($_SESSION['jwt'] ?? $user['token']); ?></span></li>
        </ul>
    </article>
    <article class="panel">
        <h2>Portal Notlari</h2>
        <p>Dosya depolama ile forum hala ayni node uzerinde. Ayrica test amacli debug katmani tamamen kaldirilmadi.</p>
        <?php if (($user['role'] ?? '') === 'admin'): ?>
            <div class="flag-box">Admin sinkronizasyonu tamamlandi: THU{sql1_byp4ss_1s_cl4ss1c}</div>
        <?php endif; ?>
    </article>
</section>

<section class="content-band three-col">
    <a class="panel link-panel" href="/profile.php?id=<?= (int) $user['id']; ?>">
        <h2>Profil</h2>
        <p>Kendi kaydini goruntule.</p>
    </a>
    <a class="panel link-panel" href="/forum.php">
        <h2>Forum</h2>
        <p>Iceride neler konusulduguna bak.</p>
    </a>
    <a class="panel link-panel" href="/upload.php">
        <h2>Dosya Yukle</h2>
        <p>Paylasim havuzuna yeni bir dosya gonder.</p>
    </a>
</section>
<?php render_footer(); ?>
