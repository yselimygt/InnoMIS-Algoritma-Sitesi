<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tournaments - Admin</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>Manage Tournaments</h1>
            <div>
                <a href="<?= APP_URL ?>/admin/tournaments/create" class="btn">Create Tournament</a>
                <a href="<?= APP_URL ?>/admin" class="btn" style="background: #555;">Back</a>
            </div>
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
                        <td><?= $t['is_active'] ? 'Active' : 'Ended' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
