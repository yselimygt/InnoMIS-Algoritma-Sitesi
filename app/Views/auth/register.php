<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container" style="max-width: 500px; margin-top: 50px;">
        <div class="card">
            <h1 class="text-center">Kayıt Ol</h1>
            <?php if (isset($error)): ?>
                <p style="color: var(--danger); text-align: center;"><?= $error ?></p>
            <?php endif; ?>
            <form action="<?= APP_URL ?>/register" method="POST">
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label>Ad</label>
                        <input type="text" name="name" required>
                    </div>
                    <div>
                        <label>Soyad</label>
                        <input type="text" name="surname" required>
                    </div>
                </div>

                <label>E-posta</label>
                <input type="email" name="email" required>
                
                <label>Şifre</label>
                <input type="password" name="password" required>
                
                <label>Öğrenci Numarası</label>
                <input type="text" name="student_number" required>
                
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label>Fakülte</label>
                        <input type="text" name="faculty">
                    </div>
                    <div>
                        <label>Bölüm</label>
                        <input type="text" name="department">
                    </div>
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label>Sınıf</label>
                        <input type="text" name="class_level">
                    </div>
                    <div>
                        <label>Telefon</label>
                        <input type="text" name="phone">
                    </div>
                </div>

                <label>İkametgah</label>
                <input type="text" name="residence">
                
                <button type="submit" class="btn" style="width: 100%;">Kayıt Ol</button>
            </form>
            <p class="text-center mt-4">Zaten hesabın var mı? <a href="<?= APP_URL ?>/login">Giriş Yap</a></p>
        </div>
    </div>
</body>
</html>
