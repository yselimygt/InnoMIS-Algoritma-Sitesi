<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
    <style>
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #fff;
            border: 2px solid var(--primary-color);
        }
        .stats {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        .stat-box {
            background: var(--card-bg);
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
        }
        .badge-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .badge-item {
            text-align: center;
            background: rgba(255,255,255,0.05);
            padding: 10px;
            border-radius: 10px;
        }
        .badge-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="profile-header card" style="flex-direction: row; align-items: center; text-align: left;">
            <div class="avatar">
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            </div>
            <div style="flex: 1;">
                <h1 style="margin: 0; font-size: 2rem;"><?= $user['name'] . ' ' . $user['surname'] ?></h1>
                <p><?= $user['faculty'] ?> - <?= $user['department'] ?></p>
                <div class="stats">
                    <div class="stat-box">
                        <div class="stat-value"><?= $user['level'] ?></div>
                        <div>Level</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?= $user['xp'] ?></div>
                        <div>XP</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h3>Badges</h3>
            <?php if (empty($badges)): ?>
                <p>No badges yet. Solve problems to earn them!</p>
            <?php else: ?>
                <div class="badge-grid">
                    <?php foreach ($badges as $badge): ?>
                    <div class="badge-item">
                        <img src="<?= APP_URL ?>/public/uploads/badges/<?= $badge['icon_path'] ?>" class="badge-icon" alt="<?= $badge['name'] ?>">
                        <div><?= $badge['name'] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3>Recent Submissions</h3>
            <table>
                <thead>
                    <tr>
                        <th>Problem</th>
                        <th>Language</th>
                        <th>Result</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $sub): ?>
                    <tr>
                        <td><a href="<?= APP_URL ?>/problem/<?= $sub['problem_slug'] ?>"><?= $sub['problem_title'] ?></a></td>
                        <td><?= $sub['language'] ?></td>
                        <td style="color: <?= $sub['result'] == 'AC' ? 'var(--secondary-color)' : 'red' ?>"><?= $sub['result'] ?></td>
                        <td><?= $sub['execution_time'] ?>s</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
