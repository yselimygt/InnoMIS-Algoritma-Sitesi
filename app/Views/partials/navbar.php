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
        <a href="<?= APP_URL ?>/forum">Forum</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php
                require_once __DIR__ . '/../../Models/NotificationModel.php';
                $notificationModel = new NotificationModel();
                $unread = $notificationModel->getUnread($_SESSION['user_id'], 5);
                $unreadCount = count($unread);
            ?>
            <div class="dropdown" style="position: relative; display: inline-block; margin-right: 10px;">
                <a href="javascript:void(0)" onclick="toggleNotif()" style="position: relative;">
                    🔔
                    <?php if ($unreadCount > 0): ?>
                        <span style="background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem; position: absolute; top: -8px; right: -10px;"><?= $unreadCount ?></span>
                    <?php endif; ?>
                </a>
                <div id="notif-menu" style="display: none; position: absolute; right: 0; background: #111827; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; padding: 10px; width: 250px; z-index: 20;">
                    <?php if ($unreadCount === 0): ?>
                        <p style="margin:0;">Yeni bildirim yok.</p>
                    <?php else: ?>
                        <?php foreach ($unread as $n): ?>
                            <div style="border-bottom: 1px solid rgba(255,255,255,0.08); padding: 6px 0;">
                                <div style="font-weight: bold;"><?= htmlspecialchars($n['title']) ?></div>
                                <div style="font-size: 0.9rem; color: #b0b8c4;"><?= htmlspecialchars($n['message']) ?></div>
                                <?php if ($n['link']): ?>
                                    <a href="<?= $n['link'] ?>" style="font-size: 0.85rem; color: var(--primary);">Git</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
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
<script>
    function toggleNotif() {
        const menu = document.getElementById('notif-menu');
        if (!menu) return;
        const willOpen = menu.style.display !== 'block';
        menu.style.display = willOpen ? 'block' : 'none';
        if (willOpen) {
            fetch('<?= APP_URL ?>/api/notifications/read-all', {method: 'POST'})
                .catch(() => {});
        }
    }
    document.addEventListener('click', (e) => {
        const menu = document.getElementById('notif-menu');
        if (!menu) return;
        if (!e.target.closest('#notif-menu') && !e.target.closest('.dropdown')) {
            menu.style.display = 'none';
        }
    });
</script>
