<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($problem['title']) ?> - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
</head>

<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="problem-container">
            <div class="problem-desc card">
                <h1><?= e($problem['title']) ?></h1>
                <div class="badge"><?= e($problem['difficulty']) ?></div>
                <div class="content" style="margin-top: 20px;">
                    <?= nl2br(e($problem['description'])) ?>
                </div>
                <h3>Girdi Formatı</h3>
                <pre><?= htmlspecialchars($problem['input_format']) ?></pre>
                <h3>Çıktı Formatı</h3>
                <pre><?= htmlspecialchars($problem['output_format']) ?></pre>
            </div>

            <div class="editor-container">
                <select id="language">
                    <option value="c">C</option>
                    <option value="cpp">C++</option>
                    <option value="python">Python</option>
                    <option value="java">Java</option>
                </select>
                <div id="editor" style="height: 400px; width: 100%;"></div>

                <div style="margin-top: 10px;">
                    <label>Özel Girdi:</label>
                    <textarea id="customInput" rows="3"></textarea>
                </div>

                <div style="margin-top: 10px; display: flex; gap: 10px;">
                    <button id="runBtn" onclick="runCode()" class="btn btn-secondary">Çalıştır</button>
                    <button id="submitBtn" onclick="submitCode()" class="btn">Gönder</button>
                </div>

                <div id="result" style="margin-top: 10px; font-weight: bold;"></div>
                <pre id="output" style="background: #000; padding: 10px; display: none; margin-top: 10px; border-radius: 5px;"></pre>
            </div>
        </div>
    </div>

    <script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/c_cpp");

        document.getElementById('language').addEventListener('change', function() {
            var lang = this.value;
            var mode = "ace/mode/c_cpp";
            if (lang == 'python') mode = "ace/mode/python";
            if (lang == 'java') mode = "ace/mode/java";
            editor.session.setMode(mode);
        });

        function submitCode() {
            var code = editor.getValue();
            var language = document.getElementById('language').value;
            var slug = <?= json_encode($problem['slug']) ?>;

            document.getElementById('result').innerText = "Çalışıyor...";

            fetch('<?= APP_URL ?>/api/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        slug: slug,
                        language: language,
                        code: code
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('result').innerText = "Sonuç: " + data.result + " (Süre: " + data.time + "s)";
                })
                .catch(error => {
                    console.error('Hata:', error);
                    document.getElementById('result').innerText = "Kod gönderilirken hata oluştu.";
                });
        }

        function runCode() {
            var code = editor.getValue();
            var language = document.getElementById('language').value;
            var input = document.getElementById('customInput').value;

            document.getElementById('result').innerText = "Çalışıyor...";
            document.getElementById('output').style.display = 'none';

            fetch('<?= APP_URL ?>/api/run-test', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        language: language,
                        code: code,
                        input: input
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('result').innerText = "Durum: " + data.status;
                    document.getElementById('output').style.display = 'block';
                    document.getElementById('output').innerText = data.output;
                });
        }
    </script>
</body>

</html>