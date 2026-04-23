<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = md5($_POST['password'] ?? '');

    // Kasıtlı SQL Enjeksiyonu Açığı
    $check = "SELECT id FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $existing = $pdo->query($check)->fetch();

    if ($existing) {
        $error = 'Bu kimlik bilgileri daha önce kaydedilmiş.';
    } else {
        $insert = "INSERT INTO users (username, password, email, role, bio, token) VALUES ('$username', '$password', '$email', 'member', 'Yeni bir üye. Henüz iz bırakmadı.', '')";
        if ($pdo->exec($insert)) {
            $message = 'Kayıt başarılı. Artık düğüme bağlanabilirsin.';
        } else {
            $error = 'Veri tabanına kayıt yazılamadı.';
        }
    }
}

render_header('Kayıt Ol', 'A quick registration flow can still trust input too much.');
?>
<section class="content-band" style="max-width: 500px; margin-left: auto; margin-right: auto;">
    <div class="panel form-panel">
        <h2 style="color: var(--pink); text-align: center; margin-bottom: 1.5rem;">Yeni Üye Kaydı</h2>
        
        <?php if ($message): ?>
            <div class="notice" style="margin-bottom: 1.5rem;"><?= e($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert" style="margin-bottom: 1.5rem;"><?= e($error); ?></div>
        <?php endif; ?>

        <form method="post" class="stack-form">
            <div>
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" placeholder="Örn: hacker1337" required autofocus>
            </div>
            <div>
                <label for="email">E-posta</label>
                <input type="email" id="email" name="email" placeholder="internal@node.local" required>
            </div>
            <div>
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <button class="button" type="submit" style="width: 100%; margin-top: 1rem;">Kayıt Ol</button>
        </form>
        
        <p class="muted" style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
            Zaten üye misin? <a href="/login.php">Giriş yap</a>.
        </p>
    </div>
</section>
<?php render_footer(); ?>
