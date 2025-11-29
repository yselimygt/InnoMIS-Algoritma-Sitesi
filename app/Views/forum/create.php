<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Başlık - Forum</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>
    <div class="container">
        <h1>Yeni Başlık Oluştur</h1>
        <form action="<?= APP_URL ?>/forum" method="POST">
            <div class="card">
                <label>Başlık</label>
                <input type="text" name="title" required>
                <label>İçerik</label>
                <textarea name="body" rows="8" required></textarea>
                <button type="submit" class="btn" style="margin-top:10px;">Yayınla</button>
            </div>
        </form>
    </div>
</body>
</html>
