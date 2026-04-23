<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = md5($_POST['password'] ?? '');

    // Kasıtlı SQL Enjeksiyonu Açığı
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $user = $pdo->query($query)->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['jwt'] = issue_jwt($user, $pdo);
        set_login_side_effects();

        header('Location: /dashboard.php');
        exit;
    }

    $error = 'Giriş başarısız. Düğüm kimliğini doğrulayamadı.';
}

render_header('Üye Girişi', 'The login form trusts you too much.');
?>
<section class="content-band" style="max-width: 500px; margin-left: auto; margin-right: auto;">
    <div class="panel form-panel">
        <h2 style="color: var(--purple); text-align: center; margin-bottom: 1.5rem;">Kimlik Doğrulama</h2>
        
        <?php if ($error): ?>
            <div class="alert" style="margin-bottom: 1.5rem;"><?= e($error); ?></div>
        <?php endif; ?>

        <form method="post" class="stack-form">
            <div>
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" placeholder="admin, moderator..." required autofocus>
            </div>
            <div>
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <button class="button" type="submit" style="width: 100%; margin-top: 1rem;">Düğüme Bağlan</button>
        </form>
        
        <p class="muted" style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
            Hesabın yok mu? <a href="/register.php">Yeni bir üye</a> kaydı oluştur.
        </p>
    </div>
</section>
<?php render_footer(); ?>
