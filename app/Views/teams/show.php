<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $team['name'] ?> - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h1><?= $team['name'] ?></h1>
                <div style="background: var(--primary-color); color: #000; padding: 5px 10px; border-radius: 5px;">
                    Invite Code: <strong><?= $team['invite_code'] ?></strong>
                </div>
            </div>
            <p><?= $team['description'] ?></p>
        </div>

        <div class="card">
            <h3>Team Members</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Level</th>
                        <th>XP</th>
                        <th>Joined At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?= $member['name'] . ' ' . $member['surname'] ?></td>
                        <td><?= $member['level'] ?></td>
                        <td><?= $member['xp'] ?></td>
                        <td><?= $member['joined_at'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
