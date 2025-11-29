<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
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
            border: 2px solid var(--primary);
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .stat-box {
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary);
        }
    </style>
</head>

<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="card profile-header">
            <div class="avatar">
                <?php
                $first = isset($profileUser['name']) ? substr((string)$profileUser['name'], 0, 1) : '';
                $last = isset($profileUser['surname']) ? substr((string)$profileUser['surname'], 0, 1) : '';
                echo strtoupper($first . $last);
                ?>
            </div>
            <div style="flex: 1;">
                <h1 style="margin: 0; font-size: 2rem;"><?= htmlspecialchars($profileUser['name'] . ' ' . $profileUser['surname']) ?></h1>
                <p><?= htmlspecialchars($profileUser['email']) ?></p>
                <div class="stats">
                    <div class="stat-box">
                        <div class="stat-value"><?= $profileUser['level'] ?? 0 ?></div>
                        <div>Seviye</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?= $profileUser['xp'] ?? 0 ?></div>
                        <div>XP</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?= $followStats['followers'] ?? 0 ?></div>
                        <div>Takipçi</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?= $followStats['following'] ?? 0 ?></div>
                        <div>Takip Edilen</div>
                    </div>
                </div>
            </div>
            <div>
                <?php if (!$isSelf && $viewerId): ?>
                    <form action="<?= APP_URL ?>/<?= $isFollowing ? 'unfollow' : 'follow' ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="user_id" value="<?= $profileUser['id'] ?>">
                        <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/profile/' . $profileUser['id']) ?>">
                        <button type="submit" class="btn" style="min-width: 160px;">
                            <?= $isFollowing ? 'Takibi Bırak' : 'Takip Et' ?>
                        </button>
                    </form>
                <?php elseif (!$viewerId): ?>
                    <a href="<?= APP_URL ?>/login" class="btn">Takip etmek için giriş yap</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid" style="margin-bottom: 30px;">
            <div class="card">
                <h3>Takipçiler (<?= $followStats['followers'] ?? 0 ?>)</h3>
                <?php if (empty($followers)): ?>
                    <p>Henüz takipçi yok.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($followers as $follower): ?>
                            <li>
                                <a href="<?= APP_URL ?>/profile/<?= $follower['id'] ?>">
                                    <?= htmlspecialchars($follower['name'] . ' ' . $follower['surname']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="card">
                <h3>Takip Edilenler (<?= $followStats['following'] ?? 0 ?>)</h3>
                <?php if (empty($following)): ?>
                    <p>Henüz kimseyi takip etmiyor.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($following as $f): ?>
                            <li>
                                <a href="<?= APP_URL ?>/profile/<?= $f['id'] ?>">
                                    <?= htmlspecialchars($f['name'] . ' ' . $f['surname']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <h2><?= $isSelf ? 'Rozetlerim' : 'Rozetler' ?></h2>
        <div class="grid">
            <?php if (empty($badges)): ?>
                <div class="card" style="grid-column: 1 / -1;">
                    <p><?= $isSelf ? 'Henüz hiç rozet kazanmadın. Problem çözmeye başla!' : 'Bu kullanıcı henüz rozet kazanmamış.' ?></p>
                </div>
            <?php else: ?>
                <?php foreach ($badges as $badge): ?>
                    <div class="card">
                        <div style="font-size: 2rem; margin-bottom: 10px;">🏅</div>
                        <h3><?= htmlspecialchars($badge['name']) ?></h3>
                        <p><?= htmlspecialchars($badge['description']) ?></p>
                        <p style="font-size: 0.8rem; color: var(--text-muted);">Kazanıldı: <?= $badge['granted_at'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <h2 style="margin-top: 30px;">Son Gönderimler</h2>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Problem</th>
                        <th>Dil</th>
                        <th>Sonuç</th>
                        <th>Süre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($submissions)): ?>
                        <tr>
                            <td colspan="4">Henüz gönderim yok.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($submissions as $sub): ?>
                            <tr>
                                <td><a href="<?= APP_URL ?>/problem/<?= $sub['problem_slug'] ?>"><?= htmlspecialchars($sub['problem_title']) ?></a></td>
                                <td><?= $sub['language'] ?></td>
                                <td style="color: <?= $sub['result'] == 'AC' ? 'var(--secondary)' : 'red' ?>"><?= $sub['result'] ?></td>
                                <td><?= $sub['execution_time'] ?>s</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>