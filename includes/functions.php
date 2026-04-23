<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/auth.php';

/**
 * HTML karakterlerini güvenli bir şekilde encode eder.
 */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Sayfa başlığını düzenler.
 */
function current_route_title($title)
{
    return $title . ' | TryHackUs CTF';
}

/**
 * Mevcut kullanıcının profil linkini döndürür.
 */
function nav_profile_link()
{
    if (!empty($_SESSION['user_id'])) {
        return '/profile.php?id=' . (int) $_SESSION['user_id'];
    }

    return '/login.php';
}

/**
 * Veritabanından flag değerini çeker.
 */
function fetch_flag(PDO $pdo, $flagName)
{
    $stmt = $pdo->prepare('SELECT flag_value FROM flags WHERE flag_name = ? LIMIT 1');
    $stmt->execute([$flagName]);
    $row = $stmt->fetch();

    return $row['flag_value'] ?? '';
}

/**
 * Admin bot simülasyonu: XSS payload'larını "ziyaret eder".
 */
function dispatch_admin_review($content)
{
    if (stripos($content, 'fetch(') === false) {
        return;
    }

    if (!preg_match('/https?:\/\/[^\'"\s<]+/', $content, $matches)) {
        return;
    }

    $target = $matches[0];
    $separator = strpos($target, '?') === false ? '?' : '&';
    @file_get_contents($target . $separator . 'c=' . urlencode('admin_bot=THU{st0r3d_xss_p3rs1sts}'));
}

/**
 * Sayfa üstbilgisini (Header) render eder.
 */
function render_header($title, $challengeHint = '')
{
    $isAdmin = (($_SESSION['role'] ?? '') === 'admin');
    ?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(current_route_title($title)); ?></title>
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="shell-grid"></div>
    <header class="site-header">
        <div class="header-left">
            <p class="eyebrow">TryHackUs İç Ağ Düğümü</p>
            <h1><?= e($title); ?></h1>
            <?php if ($challengeHint !== ''): ?>
                <p class="challenge-hint"><?= e($challengeHint); ?></p>
            <?php endif; ?>
        </div>
        <nav class="nav">
            <a href="/index.php">Anasayfa</a>
            <a href="/forum.php">Forum</a>
            <a href="/files.php">Dosyalar</a>
            <a href="<?= e(nav_profile_link()); ?>">Profil</a>
            <?php if ($isAdmin): ?>
                <a href="/admin/index.php" style="border-color: var(--pink); color: var(--pink);">Yönetim</a>
            <?php endif; ?>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="/logout.php" class="button ghost small">Çıkış</a>
            <?php else: ?>
                <a href="/login.php" class="button small">Giriş</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="page-shell">
    <?php
}

/**
 * Sayfa altbilgisini (Footer) render eder.
 */
function render_footer()
{
    ?>
    </main>
    <footer style="text-align: center; padding: 2rem; color: var(--comment); font-size: 0.8rem; position: relative; z-index: 1;">
        &copy; 2026 TryHackUs CTF Platformu. Tüm hakları gizlidir.
    </footer>
    <script src="/static/js/main.js"></script>
</body>
</html>
    <?php
}
