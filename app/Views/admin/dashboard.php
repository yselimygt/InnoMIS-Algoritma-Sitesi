<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Paneli - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .stat-grid {display:grid; grid-template-columns: repeat(auto-fit,minmax(180px,1fr)); gap:12px; margin-top:20px;}
        .stat-card {background:#111827; padding:14px; border-radius:10px; border:1px solid rgba(255,255,255,0.05);}
        .stat-card h3 {margin:0; font-size:0.95rem; color:#9ca3af;}
        .stat-card p {margin:6px 0 0; font-size:1.6rem; font-weight:bold;}
        .quick-links {display:grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap:12px; margin-top:20px;}
        .card-link {padding:14px; border:1px solid rgba(255,255,255,0.08); border-radius:10px; background:#0f172a;}
    </style>
 </head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>
    <div class="container">
        <h1>Yönetici Paneli</h1>
        <div class="stat-grid">
            <div class="stat-card">
                <h3>Kullanıcılar</h3>
                <p><?= $stats['users'] ?? 0 ?></p>
            </div>
            <div class="stat-card">
                <h3>Problemler</h3>
                <p><?= $stats['problems'] ?? 0 ?></p>
            </div>
            <div class="stat-card">
                <h3>Gönderimler</h3>
                <p><?= $stats['submissions'] ?? 0 ?></p>
            </div>
            <div class="stat-card">
                <h3>Forum Başlıkları</h3>
                <p><?= $stats['threads'] ?? 0 ?></p>
            </div>
        </div>

        <div class="quick-links">
            <a class="card-link" href="<?= APP_URL ?>/admin/users">
                <h3>Kullanıcı Yönetimi</h3>
                <p style="color:#9ca3af;">Rolleri güncelle, kullanıcıları incele.</p>
            </a>
            <a class="card-link" href="<?= APP_URL ?>/admin/problems">
                <h3>Problem Yönetimi</h3>
                <p style="color:#9ca3af;">Yeni problem oluştur, test ekle.</p>
            </a>
            <a class="card-link" href="<?= APP_URL ?>/admin/tournaments">
                <h3>Turnuva Yönetimi</h3>
                <p style="color:#9ca3af;">Turnuva oluştur ve yönet.</p>
            </a>
            <a class="card-link" href="<?= APP_URL ?>/admin/badges">
                <h3>Rozet Yönetimi</h3>
                <p style="color:#9ca3af;">Rozet ekle, düzenle.</p>
            </a>
        </div>
    </div>
</body>
</html>
