<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>
    
    <div class="container">
        <div style="text-align: center; padding: 60px 20px;">
            <h1 style="font-size: 4rem; margin-bottom: 20px;">Master Algorithms <br> with <span style="color: var(--primary);">InnoMIS</span></h1>
            <p style="font-size: 1.2rem; max-width: 600px; margin: 0 auto 40px;">
                Join the ultimate competitive programming platform. Solve problems, earn badges, compete in tournaments, and climb the leaderboard.
            </p>
            <div style="display: flex; gap: 20px; justify-content: center;">
                <a href="<?= APP_URL ?>/problems" class="btn" style="padding: 15px 40px; font-size: 1.1rem;">Start Solving</a>
                <a href="<?= APP_URL ?>/register" class="btn btn-secondary" style="padding: 15px 40px; font-size: 1.1rem;">Join Now</a>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <h3>🚀 Learn</h3>
                <p>Follow structured learning paths to master algorithms from scratch.</p>
            </div>
            <div class="card">
                <h3>🏆 Compete</h3>
                <p>Join tournaments and challenge your friends in real-time.</p>
            </div>
            <div class="card">
                <h3>✨ Earn</h3>
                <p>Collect unique badges and show off your achievements on your profile.</p>
            </div>
        </div>
    </div>
</body>
</html>
