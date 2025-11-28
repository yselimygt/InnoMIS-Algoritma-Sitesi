<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenme Yolları - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Öğrenme Yolları</h1>
        <div class="grid">
            <?php foreach ($paths as $path): ?>
            <div class="card">
                <h3><?= $path['title'] ?></h3>
                <p><?= $path['description'] ?></p>
                <span class="badge"><?= $path['level'] ?></span>
                <br><br>
                <a href="<?= APP_URL ?>/path/<?= $path['id'] ?>" class="btn">Yola Başla</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
