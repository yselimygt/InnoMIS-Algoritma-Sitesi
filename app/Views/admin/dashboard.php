<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Paneli - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <h1>Yönetici Paneli</h1>
        
        <div class="grid">
            <div class="card">
                <h3>Kullanıcılar</h3>
                <p>Kullanıcıları ve rollerini yönet.</p>
                <a href="<?= APP_URL ?>/admin/users" class="btn">Yönet</a>
            </div>
            
            <div class="card">
                <h3>Rozetler</h3>
                <p>Yeni rozetler oluştur ve yönet.</p>
                <a href="<?= APP_URL ?>/admin/badges" class="btn">Yönet</a>
            </div>
            
            <div class="card">
                <h3>Turnuvalar</h3>
                <p>Turnuvaları oluştur ve yönet.</p>
                <a href="<?= APP_URL ?>/admin/tournaments" class="btn">Yönet</a>
            </div>
        </div>
    </div>
</body>
</html>
