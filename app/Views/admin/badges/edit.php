<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozet Düzenle - <?= htmlspecialchars($badge['name']) ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>
    <div class="container">
        <h1>Rozet Düzenle</h1>
        <div class="card">
            <form action="<?= APP_URL ?>/admin/badges/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $badge['id'] ?>">
                <label>Başlık</label>
                <input type="text" name="name" value="<?= htmlspecialchars($badge['name']) ?>" required>

                <label>Slug</label>
                <input type="text" name="slug" value="<?= htmlspecialchars($badge['slug']) ?>">

                <label>Açıklama</label>
                <textarea name="description" rows="3" required><?= htmlspecialchars($badge['description']) ?></textarea>

                <label>Tür</label>
                <select name="type">
                    <option value="system" <?= $badge['type']=='system'?'selected':''; ?>>Sistem</option>
                    <option value="community" <?= $badge['type']=='community'?'selected':''; ?>>Topluluk</option>
                    <option value="event" <?= $badge['type']=='event'?'selected':''; ?>>Etkinlik</option>
                    <option value="season" <?= $badge['type']=='season'?'selected':''; ?>>Sezon</option>
                    <option value="special" <?= $badge['type']=='special'?'selected':''; ?>>Özel</option>
                </select>

                <label>Nadirlik</label>
                <select name="rarity">
                    <option value="common" <?= $badge['rarity']=='common'?'selected':''; ?>>Sık</option>
                    <option value="rare" <?= $badge['rarity']=='rare'?'selected':''; ?>>Nadir</option>
                    <option value="epic" <?= $badge['rarity']=='epic'?'selected':''; ?>>Epik</option>
                    <option value="legendary" <?= $badge['rarity']=='legendary'?'selected':''; ?>>Legendary</option>
                </select>

                <label>İkon (varsa değiştir)</label>
                <input type="file" name="icon" accept="image/*">
                <p>Mevcut: <?= htmlspecialchars($badge['icon_path']) ?></p>

                <label><input type="checkbox" name="is_active" value="1" <?= $badge['is_active'] ? 'checked' : '' ?>> Aktif</label>

                <button type="submit" class="btn" style="margin-top:10px;">Güncelle</button>
            </form>
        </div>
    </div>
</body>
</html>
