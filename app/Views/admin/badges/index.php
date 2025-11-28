<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Badges - Admin</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <div class="flex justify-between items-center">
            <h1>Badge Management</h1>
            <a href="<?= APP_URL ?>/admin/badges/create" class="btn">Create New Badge</a>
        </div>

        <div class="grid">
            <?php foreach ($badges as $badge): ?>
            <div class="card flex items-center gap-4">
                <img src="<?= APP_URL ?>/public/uploads/badges/<?= $badge['icon_path'] ?>" alt="<?= $badge['name'] ?>" style="width: 50px; height: 50px; object-fit: contain;">
                <div>
                    <h3><?= $badge['name'] ?></h3>
                    <p><?= $badge['description'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
