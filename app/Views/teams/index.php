<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Teams</h1>
        
        <?php if (isset($error)): ?>
            <div class="badge danger" style="margin-bottom: 20px; font-size: 1rem; padding: 10px;"><?= $error ?></div>
        <?php endif; ?>

        <div class="grid">
            <div class="card">
                <h3>Create a Team</h3>
                <p>Start your own team and invite friends.</p>
                <a href="<?= APP_URL ?>/teams/create" class="btn">Create Team</a>
            </div>
            
            <div class="card">
                <h3>Join a Team</h3>
                <p>Enter an invite code to join an existing team.</p>
                <form action="<?= APP_URL ?>/teams/join" method="POST">
                    <input type="text" name="invite_code" placeholder="Invite Code" required>
                    <button type="submit" class="btn btn-secondary">Join Team</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
