<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Problem - Admin - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .test-case {
            background: rgba(255,255,255,0.05);
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create New Problem</h1>
        <form action="<?= APP_URL ?>/admin/problems/store" method="POST">
            <div class="card">
                <h3>Basic Info</h3>
                <label>Title</label>
                <input type="text" name="title" required>
                
                <label>Slug (URL-friendly)</label>
                <input type="text" name="slug" required>
                
                <label>Difficulty</label>
                <select name="difficulty">
                    <option value="easy">Easy (10 XP)</option>
                    <option value="medium">Medium (20 XP)</option>
                    <option value="hard">Hard (30 XP)</option>
                </select>
                
                <label>Tags (comma separated)</label>
                <input type="text" name="tags" placeholder="math, array, string">
            </div>

            <div class="card">
                <h3>Description & Format</h3>
                <label>Description (Markdown supported)</label>
                <textarea name="description" rows="10" required></textarea>
                
                <label>Input Format</label>
                <textarea name="input_format" rows="3"></textarea>
                
                <label>Output Format</label>
                <textarea name="output_format" rows="3"></textarea>
            </div>

            <div class="card">
                <h3>Test Cases</h3>
                <div id="test-cases-container">
                    <div class="test-case">
                        <h4>Case 1 (Sample)</h4>
                        <label>Input</label>
                        <textarea name="test_cases[0][input]" rows="2" required></textarea>
                        <label>Output</label>
                        <textarea name="test_cases[0][output]" rows="2" required></textarea>
                        <label>
                            <input type="checkbox" name="test_cases[0][is_sample]" value="1" checked> Is Sample?
                        </label>
                    </div>
                </div>
                <button type="button" onclick="addTestCase()" class="btn" style="background-color: #4b5563;">+ Add Test Case</button>
            </div>

            <button type="submit" class="btn" style="width: 100%; margin-top: 20px;">Create Problem</button>
        </form>
    </div>

    <script>
        let caseCount = 1;
        function addTestCase() {
            const container = document.getElementById('test-cases-container');
            const div = document.createElement('div');
            div.className = 'test-case';
            div.innerHTML = `
                <h4>Case ${caseCount + 1}</h4>
                <label>Input</label>
                <textarea name="test_cases[${caseCount}][input]" rows="2" required></textarea>
                <label>Output</label>
                <textarea name="test_cases[${caseCount}][output]" rows="2" required></textarea>
                <label>
                    <input type="checkbox" name="test_cases[${caseCount}][is_sample]" value="1"> Is Sample?
                </label>
            `;
            container.appendChild(div);
            caseCount++;
        }
    </script>
</body>
</html>
