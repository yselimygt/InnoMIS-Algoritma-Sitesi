<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container" style="max-width: 400px; margin-top: 50px;">
        <div class="card">
            <h1 class="text-center">Giriş Yap</h1>
            <?php if (isset($error)): ?>
                <p style="color: var(--danger); text-align: center;"><?= e($error) ?></p>
            <?php endif; ?>
            <form action="<?= APP_URL ?>/login" method="POST">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <label>E-posta</label>
                <input type="email" name="email" required>

                <label>Şifre</label>
                <input type="password" name="password" required>

                <button type="submit" class="btn" style="width: 100%;">Giriş Yap</button>
            </form>
            <p class="text-center mt-4">Hesabın yok mu? <a href="<?= APP_URL ?>/register">Kayıt Ol</a></p>
        </div>
    </div>
</body>

</html>