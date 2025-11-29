<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Moderasyonu</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>
    <div class="container">
        <h1>Forum Başlıkları</h1>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>Yazar</th>
                        <th>Durum</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($threads as $thread): ?>
                        <tr>
                            <td><?= $thread['id'] ?></td>
                            <td><a href="<?= APP_URL ?>/forum/<?= $thread['slug'] ?>" target="_blank"><?= htmlspecialchars($thread['title']) ?></a></td>
                            <td><?= htmlspecialchars($thread['name'] . ' ' . $thread['surname']) ?></td>
                            <td><?= $thread['is_deleted'] ? 'Gizli' : 'Yayında' ?></td>
                            <td>
                                <form action="<?= APP_URL ?>/admin/forum/toggle" method="POST">
                                    <input type="hidden" name="thread_id" value="<?= $thread['id'] ?>">
                                    <?php if ($thread['is_deleted']): ?>
                                        <input type="hidden" name="hide" value="0">
                                        <button type="submit" class="btn">Yayına Al</button>
                                    <?php else: ?>
                                        <input type="hidden" name="hide" value="1">
                                        <button type="submit" class="btn btn-secondary">Gizle</button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
