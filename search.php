<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

$q = $_GET['q'] ?? '';
$results = [];

if ($q !== '') {
    setcookie('search_flag', 'THU{r3fl3ct3d_xss_g0t_y0u}', time() + 1800, '/');
    $sql = "SELECT title, content, created_at FROM posts WHERE title LIKE '%$q%' OR content LIKE '%$q%' ORDER BY created_at DESC LIMIT 20";
    $rows = $pdo->query($sql);
    if ($rows) {
        $results = $rows->fetchAll();
    }
}

render_header('Arama', 'The search bar remembers everything you say.');
?>
<section class="content-band">
    <div class="panel form-panel">
        <form method="get" class="stack-form">
            <label>Arama terimi
                <input type="text" name="q" value="<?= $q; ?>">
            </label>
            <button class="button" type="submit">Ara</button>
        </form>
        <?php if ($q !== ''): ?>
            <p class="muted">Aranan ifade: <?= $q; ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="content-band">
    <div class="panel">
        <h2>Sonuclar</h2>
        <?php if (!$results): ?>
            <p class="muted">Kayit bulunamadi ya da sorgu sessizce hata verdi.</p>
        <?php endif; ?>
        <?php foreach ($results as $row): ?>
            <article class="post-card">
                <h3><?= $row['title']; ?></h3>
                <div class="raw-preview"><?= $row['content']; ?></div>
                <span class="muted"><?= $row['created_at']; ?></span>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php render_footer(); ?>
