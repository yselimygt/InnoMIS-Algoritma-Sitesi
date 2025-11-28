<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Badge - Admin</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <h1>Create Badge</h1>
        <div class="card">
            <form action="<?= APP_URL ?>/admin/badges/store" method="POST" enctype="multipart/form-data">
                <label>Name</label>
                <input type="text" name="name" required>
                
                <label>Description</label>
                <textarea name="description" rows="3" required></textarea>
                
                <label>Icon</label>
                <input type="file" name="icon" required>
                
                <button type="submit" class="btn">Create Badge</button>
            </form>
        </div>
    </div>
</body>
</html>
