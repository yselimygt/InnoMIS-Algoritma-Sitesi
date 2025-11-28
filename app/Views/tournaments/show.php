<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tournament['title'] ?> - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="card">
            <h1><?= $tournament['title'] ?></h1>
            <p><?= $tournament['description'] ?></p>
            <div class="flex gap-4" style="margin-top: 10px;">
                <span class="badge">Başlangıç: <?= $tournament['start_time'] ?></span>
                <span class="badge">Bitiş: <?= $tournament['end_time'] ?></span>
            </div>
            
            <?php if (!$isParticipant && $tournament['is_active']): ?>
                <form action="<?= APP_URL ?>/tournaments/join" method="POST" style="margin-top: 20px;">
                    <input type="hidden" name="tournament_id" value="<?= $tournament['id'] ?>">
                    <button type="submit" class="btn">Turnuvaya Katıl</button>
                </form>
            <?php elseif ($isParticipant): ?>
                <p style="color: var(--success); margin-top: 10px;">Katılıyorsunuz!</p>
            <?php endif; ?>
        </div>

        <h2>Liderlik Tablosu</h2>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Sıra</th>
                        <th>Kullanıcı</th>
                        <th>Puan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $index => $p): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $p['name'] ?></td>
                        <td><?= $p['score'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
