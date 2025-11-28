<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Team - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Create a Team</h1>
        <div class="card">
            <form action="<?= APP_URL ?>/teams/store" method="POST">
                <label>Team Name</label>
                <input type="text" name="name" required>
                
                <label>Description</label>
                <textarea name="description" rows="3"></textarea>
                
                <button type="submit" class="btn">Create Team</button>
            </form>
        </div>
    </div>
</body>
</html>
