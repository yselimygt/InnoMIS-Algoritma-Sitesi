<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InnoMIS Algoritma Platformu</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>
    
    <div class="container">
        <div style="text-align: center; padding: 60px 20px;">
            <h1>InnoMIS ile <br> Algoritmaları Keşfet</h1>
            <p style="font-size: 1.2rem; max-width: 600px; margin: 20px auto;">
                En iyi rekabetçi programlama platformuna katıl. Problemleri çöz, rozetler kazan, turnuvalarda yarış ve liderlik tablosunda yüksel.
            </p>
            <div style="margin-top: 30px;">
                <a href="<?= APP_URL ?>/problems" class="btn" style="padding: 15px 30px; font-size: 1.1rem;">Çözmeye Başla</a>
                <a href="<?= APP_URL ?>/register" class="btn btn-secondary" style="padding: 15px 30px; font-size: 1.1rem; margin-left: 10px;">Aramıza Katıl</a>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <h3>🚀 Öğren</h3>
                <p>Sıfırdan algoritmaları öğrenmek için yapılandırılmış öğrenme yollarını takip et.</p>
            </div>
            <div class="card">
                <h3>🏆 Yarış</h3>
                <p>Turnuvalara katıl ve arkadaşlarına gerçek zamanlı olarak meydan oku.</p>
            </div>
            <div class="card">
                <h3>✨ Kazan</h3>
                <p>Benzersiz rozetler topla ve başarılarını profilinde sergile.</p>
            </div>
        </div>
    </div>
</body>
</html>
