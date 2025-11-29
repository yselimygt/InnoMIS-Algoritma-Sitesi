<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <div class="container" style="max-width: 480px; margin-top: 60px;">
        <div class="card">
            <h1>Admin Girişi</h1>
            <?php if (isset($error)): ?>
                <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="<?= APP_URL ?>/admin/login" method="POST">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                
                <label>E-posta</label>
                <input type="email" name="email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

                <label>Şifre</label>
                <input type="password" name="password" required>

                <button type="submit" class="btn" style="width:100%; margin-top:10px;">Giriş Yap</button>
                <p style="font-size:0.9rem; color:#9ca3af; margin-top:10px;">Yalnızca yönetici hesabı ile giriş yapılabilir.</p>
            </form>
        </div>
    </div>
</body>
</html>