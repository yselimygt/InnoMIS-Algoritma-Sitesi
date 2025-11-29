<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Günlük Seri - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .streak-container {
            text-align: center;
            padding: 50px 20px;
        }
        .fire-icon {
            font-size: 80px;
            margin-bottom: 20px;
            display: inline-block;
            animation: pulse 2s infinite;
        }
        .streak-count {
            font-size: 4rem;
            font-weight: bold;
            color: var(--primary);
            margin: 10px 0;
        }
        @keyframes pulse {
            0% { transform: scale(1); text-shadow: 0 0 0 rgba(255, 165, 0, 0.7); }
            50% { transform: scale(1.1); text-shadow: 0 0 20px rgba(255, 69, 0, 0.8); }
            100% { transform: scale(1); text-shadow: 0 0 0 rgba(255, 165, 0, 0.7); }
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="card streak-container">
            <div class="fire-icon">🔥</div>
            <h1>Günlük Seri Ateşi</h1>
            
            <div class="streak-count"><?= $user['streak_count'] ?? 0 ?> Gün</div>
            
            <p style="font-size: 1.2rem;">
                Tebrikler <strong><?= htmlspecialchars($user['name']) ?></strong>! <br>
                Algoritma çözme alışkanlığını koruyorsun.
            </p>
            
            <div style="margin-top: 30px; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; text-align: left; max-width: 600px; margin-left: auto; margin-right: auto;">
                <h3>Nasıl Çalışır?</h3>
                <ul style="list-style-position: inside; color: var(--text-muted);">
                    <li>Her gün platforma giriş yaptığında serin 1 artar.</li>
                    <li>Eğer bir gün giriş yapmazsan serin sıfırlanır!</li>
                    <li>7 günlük seriye ulaştığında "Haftalık Savaşçı" rozeti kazanırsın.</li>
                </ul>
            </div>

            <div style="margin-top: 30px;">
                <a href="<?= APP_URL ?>/problems" class="btn">Seriyi Devam Ettir (Problem Çöz)</a>
            </div>
        </div>
    </div>
</body>
</html>