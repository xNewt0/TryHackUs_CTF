<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/../includes/functions.php';

$user = current_user($pdo);

if (isset($_GET['bypass']) && $_GET['bypass'] === '1') {
    $_SESSION['admin_preview'] = true;
}

$allowed = ($_SESSION['admin_preview'] ?? false) || (($user['role'] ?? '') === 'admin');
if (!$allowed) {
    header('Location: /login.php');
    exit;
}

render_header('Admin Dugumu', 'An auth wall is only useful if it checks everyone.');
?>
<section class="content-band two-col">
    <div class="panel">
        <h2>Yonetim Baglantilari</h2>
        <ul class="terminal-list">
            <li><a href="/admin/users.php">Kullanicilar</a></li>
            <li><a href="/admin/logs.php">Log Goruntuleyici</a></li>
            <li><a href="/admin/config.php">Konfigurasyon</a></li>
            <li><a href="/api/admin.php?action=get_flags">Admin API</a></li>
        </ul>
    </div>
    <div class="panel">
        <h2>Durum</h2>
        <p>Bu panel test amacli preview modunu tamamen kapatmadan canliya alinmis.</p>
        <?php if ($_SESSION['admin_preview'] ?? false): ?>
            <div class="notice">Preview modu aktif. Rol kontrolu gevsetildi.</div>
        <?php endif; ?>
    </div>
</section>
<?php render_footer(); ?>
