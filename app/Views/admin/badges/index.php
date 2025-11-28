<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozet Yönetimi - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <div class="flex justify-between items-center mb-4">
            <h1>Rozet Yönetimi</h1>
            <a href="<?= APP_URL ?>/admin/badges/create" class="btn">Yeni Rozet Ekle</a>
        </div>

        <div class="grid">
            <?php foreach ($badges as $badge): ?>
            <div class="card">
                <div style="font-size: 2rem; margin-bottom: 10px;"><?= $badge['icon'] ?></div>
                <h3><?= $badge['name'] ?></h3>
                <p><?= $badge['description'] ?></p>
                <p style="font-size: 0.8rem; color: var(--text-muted);">Gereksinim: <?= $badge['criteria'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
