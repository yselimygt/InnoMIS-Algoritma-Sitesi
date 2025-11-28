<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Badges - Admin</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>Manage Badges</h1>
            <div>
                <a href="<?= APP_URL ?>/admin/badges/create" class="btn">Create New Badge</a>
                <a href="<?= APP_URL ?>/admin" class="btn" style="background: #555;">Back</a>
            </div>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($badges as $badge): ?>
                    <tr>
                        <td>
                            <img src="<?= APP_URL ?>/public/uploads/badges/<?= $badge['icon_path'] ?>" width="50" height="50" style="object-fit: contain;">
                        </td>
                        <td><?= $badge['name'] ?></td>
                        <td><?= $badge['description'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
