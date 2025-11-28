<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $team['name'] ?> - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h1><?= $team['name'] ?></h1>
                <div style="background: rgba(6, 182, 212, 0.2); color: var(--primary); padding: 5px 10px; border-radius: 5px;">
                    Davet Kodu: <strong><?= $team['invite_code'] ?></strong>
                </div>
            </div>
            <p><?= $team['description'] ?></p>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Oluşturan: <?= $team['creator_name'] ?></p>
        </div>

        <h2>Üyeler</h2>
        <div class="grid">
            <?php foreach ($members as $member): ?>
            <div class="card">
                <h3><?= $member['name'] . ' ' . $member['surname'] ?></h3>
                <p>Seviye: <?= $member['level'] ?> | XP: <?= $member['xp'] ?></p>
                <p style="font-size: 0.8rem; color: var(--text-muted);">Katılım: <?= $member['joined_at'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
