<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

force_login();
enable_admin_review_cookie();

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT posts.*, users.username FROM posts LEFT JOIN users ON users.id = posts.user_id WHERE posts.id = ? LIMIT 1');
$stmt->execute([$id]);
$post = $stmt->fetch();

render_header('Forum Gonderisi', 'User content is rendered as-is.');
?>
<section class="content-band">
    <article class="panel">
        <?php if (!$post): ?>
            <div class="alert">Gonderi bulunamadi.</div>
        <?php else: ?>
            <h2><?= e($post['title']); ?></h2>
            <p class="muted">Yazar: <?= e($post['username']); ?> / <?= e($post['created_at']); ?></p>
            <div class="forum-body"><?= $post['content']; ?></div>
        <?php endif; ?>
    </article>
</section>
<?php render_footer(); ?>
