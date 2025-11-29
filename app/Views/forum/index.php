<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>Forum</h1>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= APP_URL ?>/forum/olustur" class="btn">Yeni Başlık</a>
            <?php else: ?>
                <a href="<?= APP_URL ?>/login" class="btn">Giriş Yap</a>
            <?php endif; ?>
        </div>

        <div class="card">
            <?php if (empty($threads)): ?>
                <p>Henüz başlık yok.</p>
            <?php else: ?>
                <?php foreach ($threads as $thread): ?>
                    <div style="border-bottom: 1px solid rgba(255,255,255,0.1); padding: 10px 0;">
                        <a href="<?= APP_URL ?>/forum/<?= $thread['slug'] ?>" style="font-size: 1.1rem; font-weight: bold; color: var(--primary);">
                            <?= htmlspecialchars($thread['title']) ?>
                        </a>
                        <div style="font-size: 0.9rem; color: #b0b8c4;">
                            <?= htmlspecialchars($thread['name'] . ' ' . $thread['surname']) ?> • <?= $thread['created_at'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
