<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozet Oluştur - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <h1>Rozet Oluştur</h1>
        <div class="card">
            <form action="<?= APP_URL ?>/admin/badges/store" method="POST" enctype="multipart/form-data">
                <label>Başlık</label>
                <input type="text" name="name" required>

                <label>Slug (boş bırakılırsa otomatik)</label>
                <input type="text" name="slug">

                <label>Açıklama</label>
                <textarea name="description" rows="3" required></textarea>

                <label>Tür</label>
                <select name="type">
                    <option value="system">Sistem</option>
                    <option value="community">Topluluk</option>
                    <option value="event">Etkinlik</option>
                    <option value="season">Sezon</option>
                    <option value="special">Özel</option>
                </select>

                <label>Nadirlik</label>
                <select name="rarity">
                    <option value="common">Sık</option>
                    <option value="rare">Nadir</option>
                    <option value="epic">Efsanevi</option>
                    <option value="legendary">Legendary</option>
                </select>

                <label>İkon (resim) - isteğe bağlı</label>
                <input type="file" name="icon" accept="image/*">

                <label><input type="checkbox" name="is_active" value="1" checked> Aktif</label>

                <button type="submit" class="btn" style="margin-top:10px;">Kaydet</button>
            </form>
        </div>
    </div>
</body>
</html>
