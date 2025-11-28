<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tournaments - Admin</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>

    <div class="container">
        <div class="flex justify-between items-center">
            <h1>Tournament Management</h1>
            <a href="<?= APP_URL ?>/admin/tournaments/create" class="btn">Create Tournament</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tournaments as $t): ?>
                    <tr>
                        <td><?= $t['title'] ?></td>
                        <td><?= $t['start_time'] ?></td>
                        <td><?= $t['end_time'] ?></td>
                        <td>
                            <span class="badge <?= $t['is_active'] ? 'success' : 'danger' ?>">
                                <?= $t['is_active'] ? 'Active' : 'Ended' ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
