<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problem Yönetimi - Admin - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Problem Yönetimi</h1>
            <a href="<?= APP_URL ?>/admin/problems/create" class="btn">Yeni Problem</a>
        </div>
        
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>Zorluk</th>
                        <th>Durum</th>
                        <th>Slug</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($problems as $problem): ?>
                    <tr>
                        <td><?= $problem['id'] ?></td>
                        <td><?= $problem['title'] ?></td>
                        <td><?= $problem['difficulty'] ?></td>
                        <td><?= $problem['is_active'] ? 'Aktif' : 'Pasif' ?></td>
                        <td><?= $problem['slug'] ?></td>
                        <td>
                            <a href="<?= APP_URL ?>/problem/<?= $problem['slug'] ?>" target="_blank">Görüntüle</a> | 
                            <a href="<?= APP_URL ?>/admin/problems/<?= $problem['id'] ?>/edit">Düzenle</a> | 
                            <form action="<?= APP_URL ?>/admin/problems/delete" method="POST" style="display:inline;" onsubmit="return confirm('Silmek istiyor musun?');">
                                <input type="hidden" name="id" value="<?= $problem['id'] ?>">
                                <button type="submit" class="btn btn-secondary" style="padding:4px 8px;">Sil</button>
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
