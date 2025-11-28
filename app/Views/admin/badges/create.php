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
            <form action="<?= APP_URL ?>/admin/badges/store" method="POST">
                <label>Rozet Adı</label>
                <input type="text" name="name" required>
                
                <label>Açıklama</label>
                <textarea name="description" rows="3" required></textarea>
                
                <label>İkon (Emoji)</label>
                <input type="text" name="icon" placeholder="🏆" required>
                
                <label>Kriter (JSON)</label>
                <input type="text" name="criteria" placeholder='{"problems_solved": 10}' required>
                
                <button type="submit" class="btn">Rozet Oluştur</button>
            </form>
        </div>
    </div>
</body>
</html>
