<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Problems - Admin - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Manage Problems</h1>
            <a href="<?= APP_URL ?>/admin/problems/create" class="btn">Create New Problem</a>
        </div>
        
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Difficulty</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($problems as $problem): ?>
                    <tr>
                        <td><?= $problem['id'] ?></td>
                        <td><?= $problem['title'] ?></td>
                        <td><?= $problem['difficulty'] ?></td>
                        <td><?= $problem['slug'] ?></td>
                        <td>
                            <a href="<?= APP_URL ?>/problem/<?= $problem['slug'] ?>" target="_blank">View</a>
                            <!-- Edit/Delete buttons could go here -->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
