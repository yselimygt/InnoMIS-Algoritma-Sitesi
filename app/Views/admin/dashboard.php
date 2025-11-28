<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Admin Dashboard</h1>
        
        <div class="grid">
            <div class="card">
                <h3>User Management</h3>
                <p>Manage users, assign roles.</p>
                <a href="<?= APP_URL ?>/admin/users" class="btn">Manage Users</a>
            </div>
            
            <div class="card">
                <h3>Badge Management</h3>
                <p>Create and list badges.</p>
                <a href="<?= APP_URL ?>/admin/badges" class="btn">Manage Badges</a>
            </div>
            
            <div class="card">
                <h3>Tournament Management</h3>
                <p>Create and manage tournaments.</p>
                <a href="<?= APP_URL ?>/admin/tournaments" class="btn">Manage Tournaments</a>
            </div>
        </div>
    </div>
</body>
</html>
