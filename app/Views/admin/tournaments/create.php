<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnuva Oluştur - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <h1>Turnuva Oluştur</h1>
        <div class="card">
            <form action="<?= APP_URL ?>/admin/tournaments/store" method="POST">
                <label>Turnuva Başlığı</label>
                <input type="text" name="title" required>
                
                <label>Açıklama</label>
                <textarea name="description" rows="3" required></textarea>
                
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label>Başlangıç Zamanı</label>
                        <input type="datetime-local" name="start_time" required>
                    </div>
                    <div>
                        <label>Bitiş Zamanı</label>
                        <input type="datetime-local" name="end_time" required>
                    </div>
                </div>
                
                <button type="submit" class="btn">Turnuva Oluştur</button>
            </form>
        </div>
    </div>
</body>
</html>
