<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container" style="max-width: 400px; margin-top: 50px;">
        <div class="card">
            <h1 class="text-center">Login</h1>
            <?php if (isset($error)): ?>
                <p style="color: var(--danger); text-align: center;"><?= $error ?></p>
            <?php endif; ?>
            <form action="<?= APP_URL ?>/login" method="POST">
                <label>Email</label>
                <input type="email" name="email" required>
                
                <label>Password</label>
                <input type="password" name="password" required>
                
                <button type="submit" class="btn" style="width: 100%;">Login</button>
            </form>
            <p class="text-center mt-4">Don't have an account? <a href="<?= APP_URL ?>/register">Register</a></p>
        </div>
    </div>
</body>
</html>
