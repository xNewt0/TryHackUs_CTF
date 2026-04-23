<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/../includes/functions.php';
// FLAG-15: THU{l0g_1nj3ct10n_p0w3r}

$user = current_user($pdo);
$allowed = ($_SESSION['admin_preview'] ?? false) || (($user['role'] ?? '') === 'admin');
if (!$allowed) {
    header('Location: /admin/index.php');
    exit;
}

if (!empty($_GET['file'])) {
    include($_GET['file']);
    exit;
}

render_header('Loglar', 'The log viewer can do more than just view.');
?>
<section class="content-band two-col">
    <div class="panel">
        <h2>Log Goruntuleyici</h2>
        <p>Okunacak dosya parametresi verilince icerik dogrudan yuklenir.</p>
        <p class="muted">Ornek: <code>/admin/logs.php?file=../../../var/log/apache2/access.log</code></p>
    </div>
    <div class="panel">
        <h2>Operator Notu</h2>
        <p>Access log icinde bugunku ziyaretcilerle ilgili sorunlu satirlar olabilir. Include davranisi oldugu gibi birakildi.</p>
    </div>
</section>
<?php render_footer(); ?>
