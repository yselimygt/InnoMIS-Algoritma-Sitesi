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
            
            <div style="margin-top: 10px;">
                <label>Custom Input:</label>
                <textarea id="customInput" rows="3" style="width: 100%; background: #1e293b; color: #fff; border: 1px solid #334155;"></textarea>
            </div>
            
            <div style="margin-top: 10px;">
                <button id="runBtn" onclick="runCode()" style="background-color: #4b5563; margin-right: 10px;">Run with Custom Input</button>
                <button id="submitBtn" onclick="submitCode()">Submit Code</button>
            </div>
            
            <div id="result" style="margin-top: 10px; font-weight: bold;"></div>
            <pre id="output" style="background: #000; padding: 10px; display: none;"></pre>
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

        function runCode() {
            var code = editor.getValue();
            var language = document.getElementById('language').value;
            var input = document.getElementById('customInput').value;

            document.getElementById('result').innerText = "Running...";
            document.getElementById('output').style.display = 'none';

            fetch('<?= APP_URL ?>/api/run-test', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ language: language, code: code, input: input })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerText = "Status: " + data.status;
                document.getElementById('output').style.display = 'block';
                document.getElementById('output').innerText = data.output;
            });
        }
    </script>
</body>
</html>
