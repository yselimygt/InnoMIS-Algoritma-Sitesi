<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liderlik Tablosu - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Liderlik Tablosu</h1>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Sıra</th>
                        <th>Kullanıcı</th>
                        <th>Seviye</th>
                        <th>XP</th>
                        <?php if (!empty($viewerId)): ?>
                            <th>Takip</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?></td>
                            <td><?= $user['level'] ?></td>
                            <td><?= $user['xp'] ?></td>
                            <?php if (!empty($viewerId)): ?>
                                <td>
                                    <?php if ($viewerId == $user['id']): ?>
                                        <span style="color: var(--secondary); font-size: 0.9rem;">Sen</span>
                                    <?php else: ?>
                                        <?php $alreadyFollowing = in_array($user['id'], $followingIds ?? [], true); ?>
                                        <form action="<?= APP_URL ?>/<?= $alreadyFollowing ? 'unfollow' : 'follow' ?>" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="redirect_to" value="/leaderboard">                                            <button type="submit" class="btn btn-secondary" style="padding: 4px 10px; font-size: 0.8rem;">
                                                <?= $alreadyFollowing ? 'Takibi Bırak' : 'Takip Et' ?>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>