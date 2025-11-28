<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $problem['title'] ?> - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
</head>
<body>
    <div class="container problem-container">
        <div class="problem-desc">
            <h1><?= $problem['title'] ?></h1>
            <span class="badge"><?= $problem['difficulty'] ?></span>
            <div class="content">
                <?= nl2br($problem['description']) ?>
            </div>
            <h3>Input Format</h3>
            <pre><?= $problem['input_format'] ?></pre>
            <h3>Output Format</h3>
            <pre><?= $problem['output_format'] ?></pre>
        </div>
        
        <div class="editor-container">
            <select id="language">
                <option value="c">C</option>
                <option value="cpp">C++</option>
                <option value="python">Python</option>
                <option value="java">Java</option>
            </select>
            <div id="editor" style="height: 400px; width: 100%;"></div>
            <button id="submitBtn" onclick="submitCode()">Submit Code</button>
            <div id="result"></div>
        </div>
    </div>

    <script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/c_cpp");

        document.getElementById('language').addEventListener('change', function() {
            var lang = this.value;
            var mode = "ace/mode/c_cpp";
            if(lang == 'python') mode = "ace/mode/python";
            if(lang == 'java') mode = "ace/mode/java";
            editor.session.setMode(mode);
        });

        function submitCode() {
            var code = editor.getValue();
            var language = document.getElementById('language').value;
            var slug = "<?= $problem['slug'] ?>";

            document.getElementById('result').innerText = "Running...";

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
                document.getElementById('result').innerText = "Result: " + data.result + " (Time: " + data.time + "s)";
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('result').innerText = "Error submitting code.";
            });
        }
    </script>
</body>
</html>
