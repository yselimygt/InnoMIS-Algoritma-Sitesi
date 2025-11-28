<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problems - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Problem List</h2>
        <ul>
            <?php foreach ($problems as $problem): ?>
                <li>
                    <a href="<?= APP_URL ?>/problem/<?= $problem['slug'] ?>">
                        <?= $problem['title'] ?> (<?= $problem['difficulty'] ?>)
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
