<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournaments - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Tournaments</h1>
        <div class="grid">
            <?php foreach ($tournaments as $t): ?>
            <div class="card">
                <h3><?= $t['title'] ?></h3>
                <p><?= $t['description'] ?></p>
                <div class="flex justify-between items-center" style="margin-top: 10px;">
                    <span class="badge <?= $t['is_active'] ? 'success' : 'danger' ?>">
                        <?= $t['is_active'] ? 'Active' : 'Ended' ?>
                    </span>
                    <a href="<?= APP_URL ?>/tournament/<?= $t['id'] ?>" class="btn btn-secondary">View Details</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
