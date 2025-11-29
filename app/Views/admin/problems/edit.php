<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problem Düzenle - <?= htmlspecialchars($problem['title']) ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .test-case {background: rgba(255,255,255,0.05); padding: 10px; margin-bottom: 10px; border-radius: 5px;}
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../../partials/navbar.php'; ?>
    <div class="container">
        <h1>Problem Düzenle</h1>
        <form action="<?= APP_URL ?>/admin/problems/update" method="POST">
            <input type="hidden" name="id" value="<?= $problem['id'] ?>">
            <div class="card">
                <h3>Temel Bilgiler</h3>
                <label>Başlık</label>
                <input type="text" name="title" value="<?= htmlspecialchars($problem['title']) ?>" required>

                <label>Slug</label>
                <input type="text" name="slug" value="<?= htmlspecialchars($problem['slug']) ?>" required>

                <label>Zorluk</label>
                <select name="difficulty">
                    <option value="easy" <?= $problem['difficulty']=='easy'?'selected':''; ?>>Kolay</option>
                    <option value="medium" <?= $problem['difficulty']=='medium'?'selected':''; ?>>Orta</option>
                    <option value="hard" <?= $problem['difficulty']=='hard'?'selected':''; ?>>Zor</option>
                </select>

                <label>Etiketler (virgül ile)</label>
                <input type="text" name="tags" value="<?= htmlspecialchars($problem['tags']) ?>">

                <label>
                    <input type="checkbox" name="is_active" value="1" <?= $problem['is_active'] ? 'checked' : '' ?>> Aktif
                </label>
            </div>

            <div class="card">
                <h3>Açıklama ve Format</h3>
                <label>Açıklama</label>
                <textarea name="description" rows="8" required><?= htmlspecialchars($problem['description']) ?></textarea>

                <label>Girdi Formatı</label>
                <textarea name="input_format" rows="3"><?= htmlspecialchars($problem['input_format']) ?></textarea>

                <label>Çıktı Formatı</label>
                <textarea name="output_format" rows="3"><?= htmlspecialchars($problem['output_format']) ?></textarea>
            </div>

            <div class="card">
                <h3>Mevcut Testler</h3>
                <?php if (empty($cases)): ?>
                    <p>Test case yok.</p>
                <?php else: ?>
                    <?php foreach ($cases as $c): ?>
                        <div class="test-case">
                            <strong>#<?= $c['id'] ?> <?= $c['is_sample'] ? '(Örnek)' : '' ?></strong>
                            <p><b>Input:</b> <pre><?= htmlspecialchars($c['input']) ?></pre></p>
                            <p><b>Output:</b> <pre><?= htmlspecialchars($c['output']) ?></pre></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="card">
                <h3>Yeni Test Case Ekle (isteğe bağlı)</h3>
                <div id="test-cases-container">
                    <div class="test-case">
                        <label>Input</label>
                        <textarea name="test_cases[0][input]" rows="2"></textarea>
                        <label>Output</label>
                        <textarea name="test_cases[0][output]" rows="2"></textarea>
                        <label><input type="checkbox" name="test_cases[0][is_sample]" value="1"> Örnek</label>
                    </div>
                </div>
                <button type="button" onclick="addTestCase()" class="btn" style="background:#4b5563;">+ Test Case</button>
            </div>

            <button type="submit" class="btn" style="width:100%; margin-top:15px;">Kaydet</button>
        </form>
    </div>
    <script>
        let caseCount = 1;
        function addTestCase() {
            const container = document.getElementById('test-cases-container');
            const div = document.createElement('div');
            div.className = 'test-case';
            div.innerHTML = `
                <label>Input</label>
                <textarea name="test_cases[${caseCount}][input]" rows="2"></textarea>
                <label>Output</label>
                <textarea name="test_cases[${caseCount}][output]" rows="2"></textarea>
                <label><input type="checkbox" name="test_cases[${caseCount}][is_sample]" value="1"> Örnek</label>
            `;
            container.appendChild(div);
            caseCount++;
        }
    </script>
</body>
</html>
