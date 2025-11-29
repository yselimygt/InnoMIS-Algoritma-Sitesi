<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnuva Düzenle - <?= htmlspecialchars($tournament['title']) ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <h1>Turnuva Düzenle</h1>
        <div class="card">
            <form action="<?= APP_URL ?>/admin/tournaments/update" method="POST">
                <input type="hidden" name="id" value="<?= $tournament['id'] ?>">
                <label>Turnuva Başlığı</label>
                <input type="text" name="title" value="<?= htmlspecialchars($tournament['title']) ?>" required>
                
                <label>Açıklama</label>
                <textarea name="description" rows="3" required><?= htmlspecialchars($tournament['description']) ?></textarea>
                
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label>Başlangıç Zamanı</label>
                        <input type="datetime-local" name="start_time" value="<?= date('Y-m-d\TH:i', strtotime($tournament['start_time'])) ?>" required>
                    </div>
                    <div>
                        <label>Bitiş Zamanı</label>
                        <input type="datetime-local" name="end_time" value="<?= date('Y-m-d\TH:i', strtotime($tournament['end_time'])) ?>" required>
                    </div>
                </div>

                <label><input type="checkbox" name="is_active" value="1" <?= $tournament['is_active'] ? 'checked' : '' ?>> Aktif</label>
                
                <button type="submit" class="btn" style="margin-top:10px;">Güncelle</button>
            </form>
        </div>
    </div>
</body>
</html>
