<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnuva Yönetimi</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1>Turnuva Yönetimi</h1>
            <a href="<?= APP_URL ?>/admin/tournaments/create" class="btn">Yeni Turnuva</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>Başlangıç</th>
                        <th>Bitiş</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tournaments as $t): ?>
                    <tr>
                        <td><?= $t['id'] ?></td>
                        <td><?= htmlspecialchars($t['title']) ?></td>
                        <td><?= $t['start_time'] ?></td>
                        <td><?= $t['end_time'] ?></td>
                        <td><?= $t['is_active'] ? 'Aktif' : 'Pasif' ?></td>
                        <td>
                            <a href="<?= APP_URL ?>/tournament/<?= $t['id'] ?>" target="_blank">Görüntüle</a> | 
                            <a href="<?= APP_URL ?>/admin/tournaments/<?= $t['id'] ?>/edit">Düzenle</a> | 
                            <form action="<?= APP_URL ?>/admin/tournaments/delete" method="POST" style="display:inline;" onsubmit="return confirm('Silinsin mi?');">
                                <input type="hidden" name="id" value="<?= $t['id'] ?>">
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
