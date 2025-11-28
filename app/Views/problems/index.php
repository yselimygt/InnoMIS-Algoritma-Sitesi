<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problems - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>
    
    <div class="container">
        <div class="flex justify-between items-center mb-4">
            <h1>Problems</h1>
        </div>

        <div class="grid">
            <?php foreach ($problems as $problem): ?>
            <div class="card">
                <h3><?= $problem['title'] ?></h3>
                <p><?= $problem['difficulty'] ?></p>
                <a href="<?= APP_URL ?>/problem/<?= $problem['slug'] ?>" class="btn">Solve</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
