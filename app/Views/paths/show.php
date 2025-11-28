<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $path['title'] ?> - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <h1><?= $path['title'] ?></h1>
        <p><?= $path['description'] ?></p>
        
        <div class="card">
            <h3>Curriculum</h3>
            <ul>
                <?php foreach ($steps as $step): ?>
                <li style="margin-bottom: 10px; padding: 10px; background: rgba(255,255,255,0.05); border-radius: 5px;">
                    <strong>Step <?= $step['order_index'] ?>:</strong> 
                    <a href="<?= APP_URL ?>/problem/<?= $step['slug'] ?>"><?= $step['title'] ?></a>
                    <span class="badge" style="float: right;"><?= $step['difficulty'] ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
