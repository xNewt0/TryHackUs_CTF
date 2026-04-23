<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

force_login();

$stmt = $pdo->prepare('SELECT * FROM files WHERE user_id = ? ORDER BY uploaded_at DESC');
$stmt->execute([$_SESSION['user_id']]);
$files = $stmt->fetchAll();

$previewContent = '';
if (!empty($_GET['preview'])) {
    $previewContent = @file_get_contents(__DIR__ . '/uploads/' . $_GET['preview']);
}

render_header('Dosyalar', 'Browse what the upload node has collected.');
?>
<section class="content-band two-col">
    <div class="panel">
        <h2>Kayitli Dosyalar</h2>
        <?php if (!$files): ?>
            <p class="muted">Henuz dosya yok.</p>
        <?php endif; ?>
        <?php foreach ($files as $file): ?>
            <article class="post-card">
                <div class="post-head">
                    <strong><?= e($file['original_name']); ?></strong>
                    <span><?= e($file['uploaded_at']); ?></span>
                </div>
                <div class="button-row">
                    <a class="button ghost small" href="/download.php?file=<?= urlencode($file['filename']); ?>">Indir</a>
                    <a class="button ghost small" href="/files.php?preview=<?= urlencode($file['filename']); ?>">Onizle</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <div class="panel">
        <h2>Onizleme</h2>
        <?php if ($previewContent !== ''): ?>
            <pre class="code-block"><?= e($previewContent); ?></pre>
        <?php else: ?>
            <p class="muted">Bir dosya secildiginde burada gorunur.</p>
        <?php endif; ?>
    </div>
</section>
<?php render_footer(); ?>
