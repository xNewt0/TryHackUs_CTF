<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

force_login();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $allowed = ['image/png', 'image/jpeg', 'image/gif'];

    if (!in_array($file['type'], $allowed, true)) {
        $error = 'Yalnizca goruntu yuklenebilir.';
    } else {
        $name = basename($file['name']);
        $target = __DIR__ . '/uploads/' . $name;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            $stmt = $pdo->prepare('INSERT INTO files (user_id, filename, original_name, filepath) VALUES (?, ?, ?, ?)');
            $stmt->execute([$_SESSION['user_id'], $name, $file['name'], '/uploads/' . $name]);
            $message = 'Dosya yüklendi: /uploads/' . $name;
        } else {
            $error = 'Yukleme basarisiz oldu.';
        }
    }
}

render_header('Dosya Yukle', 'They tried to block uploads. Did they succeed?');
?>
<section class="content-band two-col">
    <div class="panel form-panel">
        <h2>Yukleme Havuzu</h2>
        <?php if ($message): ?>
            <div class="notice break-all"><?= e($message); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert"><?= e($error); ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="stack-form">
            <label>Dosya sec
                <input type="file" name="file" required>
            </label>
            <button class="button" type="submit">Yukle</button>
        </form>
    </div>
    <div class="panel">
        <h2>Politika</h2>
        <p>Sistem yalnizca tarayicinin bildirdigi tur bilgisini dikkate alir. Icerigi daha derin inceleyen bir filtre aktif degil.</p>
        <a class="button ghost" href="/files.php">Yuklenenleri Gor</a>
    </div>
</section>
<?php render_footer(); ?>
