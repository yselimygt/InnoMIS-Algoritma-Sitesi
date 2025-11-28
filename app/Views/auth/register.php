<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <form action="<?= APP_URL ?>/register" method="POST">
            <label>Name:</label> <input type="text" name="name" required><br>
            <label>Surname:</label> <input type="text" name="surname" required><br>
            <label>Email:</label> <input type="email" name="email" required><br>
            <label>Password:</label> <input type="password" name="password" required><br>
            <label>Student Number:</label> <input type="text" name="student_number" required><br>
            <label>Faculty:</label> <input type="text" name="faculty"><br>
            <label>Department:</label> <input type="text" name="department"><br>
            <label>Class Level:</label> <input type="text" name="class_level"><br>
            <label>Residence:</label> <input type="text" name="residence"><br>
            <label>Phone:</label> <input type="text" name="phone"><br>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="<?= APP_URL ?>/login">Login</a></p>
    </div>
</body>
</html>
