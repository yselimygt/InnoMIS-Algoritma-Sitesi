<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container" style="max-width: 500px; margin-top: 50px;">
        <div class="card">
            <h1 class="text-center">Register</h1>
            <?php if (isset($error)): ?>
                <p style="color: var(--danger); text-align: center;"><?= $error ?></p>
            <?php endif; ?>
            <form action="<?= APP_URL ?>/register" method="POST">
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label>Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div>
                        <label>Surname</label>
                        <input type="text" name="surname" required>
                    </div>
                </div>

                <label>Email</label>
                <input type="email" name="email" required>
                
                <label>Password</label>
                <input type="password" name="password" required>
                
                <label>Student Number</label>
                <input type="text" name="student_number" required>
                
                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label>Faculty</label>
                        <input type="text" name="faculty">
                    </div>
                    <div>
                        <label>Department</label>
                        <input type="text" name="department">
                    </div>
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label>Class Level</label>
                        <input type="text" name="class_level">
                    </div>
                    <div>
                        <label>Phone</label>
                        <input type="text" name="phone">
                    </div>
                </div>

                <label>Residence</label>
                <input type="text" name="residence">
                
                <button type="submit" class="btn" style="width: 100%;">Register</button>
            </form>
            <p class="text-center mt-4">Already have an account? <a href="<?= APP_URL ?>/login">Login</a></p>
        </div>
    </div>
</body>
</html>
