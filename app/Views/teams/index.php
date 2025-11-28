<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Takımlar - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Takımlar</h1>
        
        <?php if (isset($error)): ?>
            <div class="badge danger" style="margin-bottom: 20px; font-size: 1rem; padding: 10px;"><?= $error ?></div>
        <?php endif; ?>

        <div class="grid">
            <div class="card">
                <h3>Takım Oluştur</h3>
                <p>Kendi takımını kur ve arkadaşlarını davet et.</p>
                <a href="<?= APP_URL ?>/teams/create" class="btn">Takım Oluştur</a>
            </div>
            
            <div class="card">
                <h3>Takıma Katıl</h3>
                <p>Mevcut bir takıma katılmak için davet kodunu gir.</p>
                <form action="<?= APP_URL ?>/teams/join" method="POST">
                    <input type="text" name="invite_code" placeholder="Davet Kodu" required>
                    <button type="submit" class="btn btn-secondary">Takıma Katıl</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
