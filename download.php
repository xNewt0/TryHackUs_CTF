<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

force_login();

$file = $_GET['file'] ?? '';

if ($file === '') {
    render_header('Indir', 'The download feature is more powerful than you think.');
    ?>
    <section class="content-band">
        <div class="panel">
            <p>Dosya adi vermedin. Ornek: <code>/download.php?file=example.txt</code></p>
        </div>
    </section>
    <?php
    render_footer();
    exit;
}

$target = __DIR__ . '/uploads/' . $file;
header('Content-Type: application/octet-stream');
header('Content-Disposition: inline; filename="' . basename($file) . '"');
readfile($target);
exit;
