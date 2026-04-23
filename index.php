<?php
session_start();
error_reporting(0);

require_once __DIR__ . '/includes/functions.php';

render_header('Hoş Geldin', 'Every server has rules. Have you read ours?');
?>
<section class="hero">
    <div class="hero-copy">
        <p>TryHackUs uzun süredir kendi üyelerine özel kapalı bir portal kullanıyor. Dışarıdan bakıldığında sessiz, içeride ise forumlar, dosya paylaşımı ve yönetim düğümleri var.</p>
        <p>Burası güvenli görünmek için tasarlandı. İz bırakmadan bakmayı biliyorsan, sistem seninle konuşmaya başlar.</p>
        <div class="button-row">
            <a class="button" href="/login.php">Giriş Yap</a>
            <a class="button secondary" href="/register.php">Üye Kaydı</a>
            <a class="button ghost" href="/search.php?q=hoşgeldin">Hızlı Arama</a>
        </div>
    </div>
    <div class="panel">
        <h2 style="color: var(--pink);">Ağ Durumu</h2>
        <ul class="terminal-list">
            <li>Portal <span>AKTİF</span></li>
            <li>Forum Devriyesi <span>DENGESİZ</span></li>
            <li>Dosya Depolama <span>AÇIK</span></li>
            <li>C2 Bağlantısı <span>GİZLİ</span></li>
        </ul>
        <p class="muted" style="margin-top: 1rem; font-size: 0.8rem;">
            * Tüm sistemler 256-bit şifreleme ile (sözde) korunmaktadır.
        </p>
    </div>
</section>

<section class="content-band two-col">
    <article class="panel">
        <h2 style="color: var(--cyan);">Operasyon Hikayesi</h2>
        <p>Yeraltında faaliyet gösteren TryHackUs, kendi operasyon notlarını bu düğüm (node) üzerinden paylaşıyor. Bazı ekip üyeleri sistemi aşırı rahat kullanıyor; bu da iz sürmek isteyenler için yeterli açık kapı bırakıyor.</p>
    </article>
    <article class="panel">
        <h2 style="color: var(--yellow);">Challenge Notes</h2>
        <p class="muted">English hints appear across the portal to guide your infiltration. The story, status texts and errors remain Turkish to keep the underground atmosphere authentic.</p>
        <div class="flag-box" style="border-color: var(--purple); color: var(--purple); background: transparent;">
            Hedef: 20 Flag toplamak.
        </div>
    </article>
</section>
<?php render_footer(); ?>
