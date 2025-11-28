<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournaments - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Tournaments</h1>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tournaments as $t): ?>
                    <tr>
                        <td><?= $t['title'] ?></td>
                        <td><?= $t['start_time'] ?></td>
                        <td><?= $t['end_time'] ?></td>
                        <td><?= $t['is_active'] ? 'Active' : 'Upcoming/Ended' ?></td>
                        <td><a href="<?= APP_URL ?>/tournament/<?= $t['id'] ?>" class="btn">View</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
