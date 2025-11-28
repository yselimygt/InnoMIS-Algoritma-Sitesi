<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tournament['title'] ?> - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1><?= $tournament['title'] ?></h1>
            <p><?= $tournament['description'] ?></p>
            <p><strong>Start:</strong> <?= $tournament['start_time'] ?> | <strong>End:</strong> <?= $tournament['end_time'] ?></p>
            
            <form action="<?= APP_URL ?>/tournaments/join" method="POST">
                <input type="hidden" name="tournament_id" value="<?= $tournament['id'] ?>">
                <button type="submit" class="btn">Join Tournament</button>
            </form>
        </div>

        <div class="card">
            <h3>Participants & Live Score</h3>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>User</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $index => $p): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $p['name'] . ' ' . $p['surname'] ?></td>
                        <td><?= $p['score'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
