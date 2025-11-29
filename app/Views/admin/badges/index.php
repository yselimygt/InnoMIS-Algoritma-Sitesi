<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozet Yönetimi - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <div class="flex justify-between items-center mb-4" style="display:flex; justify-content:space-between; align-items:center;">
            <h1>Rozet Yönetimi</h1>
            <a href="<?= APP_URL ?>/admin/badges/create" class="btn">Yeni Rozet Ekle</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>Slug</th>
                        <th>Tür</th>
                        <th>Nadirlik</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($badges as $badge): ?>
                    <tr>
                        <td><?= $badge['id'] ?></td>
                        <td><?= htmlspecialchars($badge['name']) ?></td>
                        <td><?= htmlspecialchars($badge['slug']) ?></td>
                        <td><?= $badge['type'] ?></td>
                        <td><?= $badge['rarity'] ?></td>
                        <td><?= $badge['is_active'] ? 'Aktif' : 'Pasif' ?></td>
                        <td>
                            <a href="<?= APP_URL ?>/admin/badges/<?= $badge['id'] ?>/edit">Düzenle</a> | 
                            <form action="<?= APP_URL ?>/admin/badges/delete" method="POST" style="display:inline;" onsubmit="return confirm('Silinsin mi?');">
                                <input type="hidden" name="id" value="<?= $badge['id'] ?>">
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
