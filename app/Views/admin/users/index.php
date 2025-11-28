<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <h1>User Management</h1>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <span class="badge <?= $user['role'] === 'admin' ? 'danger' : 'success' ?>">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </td>
                        <td>
                            <form action="<?= APP_URL ?>/admin/users/update-role" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <select name="role" onchange="this.form.submit()" style="width: auto; padding: 5px; margin: 0;">
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
