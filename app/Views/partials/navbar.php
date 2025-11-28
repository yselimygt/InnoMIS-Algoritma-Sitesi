<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar">
    <div class="nav-brand">
        <a href="<?= APP_URL ?>/" style="color: inherit;">Inno<span>MIS</span></a>
    </div>
    <div class="nav-links">
        <a href="<?= APP_URL ?>/problems">Problemler</a>
        <a href="<?= APP_URL ?>/leaderboard">Liderlik Tablosu</a>
        <a href="<?= APP_URL ?>/tournaments">Turnuvalar</a>
        <a href="<?= APP_URL ?>/teams">Takımlar</a>
        <a href="<?= APP_URL ?>/paths">Öğrenme Yolları</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?= APP_URL ?>/admin" style="color: var(--secondary);">Yönetici</a>
            <?php endif; ?>
            <a href="<?= APP_URL ?>/profile">Profil</a>
            <a href="<?= APP_URL ?>/logout" class="btn btn-secondary" style="padding: 5px 15px; font-size: 0.8rem;">Çıkış Yap</a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/login">Giriş Yap</a>
            <a href="<?= APP_URL ?>/register" class="btn" style="padding: 5px 15px; font-size: 0.8rem;">Kayıt Ol</a>
        <?php endif; ?>
    </div>
</nav>
