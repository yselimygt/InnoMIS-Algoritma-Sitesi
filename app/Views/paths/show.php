<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($path['title']) ?> - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .progress-shell {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 999px;
            height: 14px;
            width: 100%;
            margin-top: 10px;
        }

        .progress-fill {
            background: var(--secondary);
            height: 100%;
            border-radius: 999px;
            transition: width 0.3s ease;
        }

        .step-card.completed {
            border: 1px solid var(--secondary);
            box-shadow: 0 0 10px rgba(0, 150, 136, 0.3);
        }
    </style>
</head>

<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="card">
            <h1><?= htmlspecialchars($path['title']) ?></h1>
            <p><?= htmlspecialchars($path['description']) ?></p>
            <?php if (!empty($viewerId) && $progressSummary): ?>
                <div style="margin-top: 10px;">
                    <strong><?= $progressSummary['completed'] ?>/<?= $progressSummary['total'] ?> adım tamamlandı</strong>
                    <div class="progress-shell">
                        <div class="progress-fill" style="width: <?= $progressSummary['percentage'] ?>%"></div>
                    </div>
                    <small>%<?= $progressSummary['percentage'] ?> tamamlandı</small>
                </div>
                <form action="<?= APP_URL ?>/path/<?= $path['id'] ?>/remind" method="POST" style="margin-top: 12px; display:inline-block;">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="btn btn-secondary" style="padding: 6px 16px; font-size: 0.9rem;">Hatırlatma gönder</button>
                </form>
            <?php elseif (empty($viewerId)): ?>
                <p style="margin-top: 10px;">İlerlemeyi takip etmek için <a href="<?= APP_URL ?>/login">giriş yap</a>.</p>
            <?php endif; ?>
        </div>

        <h2>Adımlar</h2>
        <div class="grid">
            <?php foreach ($steps as $index => $step): ?>
                <?php
                $isCompleted = !empty($completedSteps) && in_array($step['id'], $completedSteps, true);
                ?>
                <div class="card step-card <?= $isCompleted ? 'completed' : '' ?>">
                    <h3>Adım <?= $index + 1 ?>: <?= htmlspecialchars($step['title']) ?></h3>
                    <?php $desc = $step['problem_description'] ?? ''; ?>
                    <?php if ($desc !== ''): ?>
                        <p><?= htmlspecialchars($desc) ?></p>
                    <?php endif; ?>
                    <div class="flex justify-between items-center">
                        <span class="badge"><?= htmlspecialchars($step['difficulty']) ?></span>
                        <a href="<?= APP_URL ?>/problem/<?= $step['slug'] ?>" class="btn btn-secondary">Problemi Çöz</a>
                    </div>
                    <?php if (!empty($viewerId)): ?>
                        <form action="<?= APP_URL ?>/path/<?= $path['id'] ?>/steps/toggle" method="POST" style="margin-top: 10px;">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <input type="hidden" name="step_id" value="<?= $step['id'] ?>">
                            <input type="hidden" name="complete" value="<?= $isCompleted ? '0' : '1' ?>">
                            <button type="submit" class="btn" style="width: 100%; background: <?= $isCompleted ? 'var(--danger)' : 'var(--secondary)' ?>;">
                                <?= $isCompleted ? 'Tamamlandı işaretini kaldır' : 'Adımı tamamladım' ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>