<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/../includes/functions.php';

$user = current_user($pdo);
$allowed = ($_SESSION['admin_preview'] ?? false) || (($user['role'] ?? '') === 'admin');
if (!$allowed) {
    header('Location: /admin/index.php');
    exit;
}

$stmt = $pdo->query('SELECT id, username, email, role, created_at FROM users ORDER BY id ASC');
$users = $stmt->fetchAll();

render_header('Admin Kullanicilar', 'Privilege should be enforced on the server.');
?>
<section class="content-band">
    <div class="panel">
        <h2>Uyeler</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kullanici</th>
                    <th>E-posta</th>
                    <th>Rol</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $row): ?>
                    <tr>
                        <td><?= (int) $row['id']; ?></td>
                        <td><?= e($row['username']); ?></td>
                        <td><?= e($row['email']); ?></td>
                        <td><?= e($row['role']); ?></td>
                        <td><?= e($row['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php render_footer(); ?>
