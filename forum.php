<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

force_login();
enable_admin_review_cookie();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title !== '' && $content !== '') {
        $stmt = $pdo->prepare('INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)');
        $stmt->execute([$_SESSION['user_id'], $title, $content]);
        dispatch_admin_review($content);
        $message = 'Post dugume birakildi.';
    }
}

$stmt = $pdo->query('SELECT posts.id, posts.title, posts.content, posts.created_at, users.username FROM posts LEFT JOIN users ON users.id = posts.user_id ORDER BY posts.created_at DESC LIMIT 20');
$posts = $stmt->fetchAll();

render_header('Forum', 'Can you make the admin click something?');
?>
<section class="content-band two-col">
    <div class="panel form-panel">
        <h2>Yeni Baslik</h2>
        <?php if ($message): ?>
            <div class="notice"><?= e($message); ?></div>
        <?php endif; ?>
        <form method="post" class="stack-form">
            <label>Baslik
                <input type="text" name="title" maxlength="200" required>
            </label>
            <label>Icerik
                <textarea name="content" rows="8" required></textarea>
            </label>
            <button class="button" type="submit">Yayinla</button>
        </form>
    </div>
    <div class="panel">
        <h2>Son Mesajlar</h2>
        <?php foreach ($posts as $post): ?>
            <article class="post-card">
                <div class="post-head">
                    <strong><?= e($post['title']); ?></strong>
                    <span><?= e($post['username']); ?> / <?= e($post['created_at']); ?></span>
                </div>
                <div class="raw-preview"><?= substr($post['content'], 0, 160); ?></div>
                <a class="button ghost small" href="/forum_post.php?id=<?= (int) $post['id']; ?>">Ac</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php render_footer(); ?>
