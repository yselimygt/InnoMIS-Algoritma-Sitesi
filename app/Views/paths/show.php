<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $path['title'] ?> - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="card">
            <h1><?= $path['title'] ?></h1>
            <p><?= $path['description'] ?></p>
        </div>

        <h2>Adımlar</h2>
        <div class="grid">
            <?php foreach ($steps as $index => $step): ?>
            <div class="card">
                <h3>Adım <?= $index + 1 ?>: <?= $step['title'] ?></h3>
                <p><?= $step['description'] ?></p>
                <div class="flex justify-between items-center">
                    <span class="badge"><?= $step['difficulty'] ?></span>
                    <a href="<?= APP_URL ?>/problem/<?= $step['slug'] ?>" class="btn btn-secondary">Problemi Çöz</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
