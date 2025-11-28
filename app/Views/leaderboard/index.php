<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <h1>Leaderboard</h1>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>User</th>
                        <th>Level</th>
                        <th>XP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?></td>
                        <td><?= $user['level'] ?></td>
                        <td><?= $user['xp'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function updateLeaderboard() {
            fetch('<?= APP_URL ?>/api/leaderboard')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('tbody');
                    tbody.innerHTML = '';
                    
                    data.forEach((user, index) => {
                        const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${user.name} ${user.surname}</td>
                                <td>${user.level}</td>
                                <td>${user.xp}</td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                });
        }

        setInterval(updateLeaderboard, 5000); // Refresh every 5 seconds
    </script>
</body>
</html>
