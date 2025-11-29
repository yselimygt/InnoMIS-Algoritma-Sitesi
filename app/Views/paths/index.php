<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenme Yolları - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .progress-shell {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 999px;
            height: 10px;
            width: 100%;
            margin: 8px 0;
        }

        .progress-fill {
            background: var(--secondary);
            height: 100%;
            border-radius: 999px;
        }
    </style>
</head>

<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Öğrenme Yolları</h1>
        <div class="grid">
            <?php foreach ($paths as $path): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($path['title']) ?></h3>
                    <p><?= htmlspecialchars($path['description']) ?></p>
                    <span class="badge"><?= htmlspecialchars($path['level']) ?></span>
                    <?php if (!empty($viewerId) && isset($progressMap[$path['id']])): ?>
                        <?php $progress = $progressMap[$path['id']]; ?>
                        <div class="progress-shell">
                            <div class="progress-fill" style="width: <?= $progress['percentage'] ?>%"></div>
                        </div>
                        <small><?= $progress['completed'] ?>/<?= $progress['total'] ?> adım tamamlandı</small>
                    <?php endif; ?>
                    <br><br>
                    <a href="<?= APP_URL ?>/path/<?= $path['id'] ?>" class="btn">Yola Başla</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>