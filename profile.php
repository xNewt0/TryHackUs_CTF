<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

force_login();

$id = $_GET['id'] ?? $_SESSION['user_id'];
$profile = $pdo->query("SELECT id, username, email, role, bio, token, created_at FROM users WHERE id = $id LIMIT 1")->fetch();

render_header('Profil', 'Are you sure you can only see your own profile?');
?>
<section class="content-band">
    <article class="panel">
        <?php if (!$profile): ?>
            <div class="alert">Profil bulunamadi.</div>
        <?php else: ?>
            <h2><?= e($profile['username']); ?></h2>
            <ul class="terminal-list">
                <li>ID: <?= (int) $profile['id']; ?></li>
                <li>E-posta: <?= e($profile['email']); ?></li>
                <li>Rol: <?= e($profile['role']); ?></li>
                <li>Kayit: <?= e($profile['created_at']); ?></li>
            </ul>
            <div class="panel inset">
                <h3>Bio</h3>
                <p class="break-all"><?= e($profile['bio']); ?></p>
            </div>
        <?php endif; ?>
    </article>
</section>
<?php render_footer(); ?>
