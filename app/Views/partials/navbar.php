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
        <a href="<?= APP_URL ?>/problems">Problems</a>
        <a href="<?= APP_URL ?>/leaderboard">Leaderboard</a>
        <a href="<?= APP_URL ?>/tournaments">Tournaments</a>
        <a href="<?= APP_URL ?>/teams">Teams</a>
        <a href="<?= APP_URL ?>/paths">Paths</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?= APP_URL ?>/admin" style="color: var(--secondary);">Admin</a>
            <?php endif; ?>
            <a href="<?= APP_URL ?>/profile">Profile</a>
            <a href="<?= APP_URL ?>/logout" class="btn btn-secondary" style="padding: 5px 15px; font-size: 0.8rem;">Logout</a>
        <?php else: ?>
            <a href="<?= APP_URL ?>/login">Login</a>
            <a href="<?= APP_URL ?>/register" class="btn" style="padding: 5px 15px; font-size: 0.8rem;">Register</a>
        <?php endif; ?>
    </div>
</nav>
