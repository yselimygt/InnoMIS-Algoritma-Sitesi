<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Paths - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Learning Paths</h1>
        <div class="grid">
            <?php foreach ($paths as $path): ?>
            <div class="card">
                <h3><?= $path['title'] ?></h3>
                <p><?= $path['description'] ?></p>
                <span class="badge"><?= $path['level'] ?></span>
                <br><br>
                <a href="<?= APP_URL ?>/path/<?= $path['id'] ?>" class="btn">Start Path</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
