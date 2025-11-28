<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams - InnoMIS</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Teams</h1>
        <div class="card">
            <h3>You are not in a team yet.</h3>
            <p>Join a team to compete in tournaments and collaborate with friends.</p>
            
            <div style="display: flex; gap: 20px; margin-top: 20px;">
                <div style="flex: 1;">
                    <h4>Create a Team</h4>
                    <form action="<?= APP_URL ?>/teams/create" method="GET">
                        <button type="submit" class="btn">Create Team</button>
                    </form>
                </div>
                <div style="flex: 1; border-left: 1px solid var(--border-color); padding-left: 20px;">
                    <h4>Join a Team</h4>
                    <form action="<?= APP_URL ?>/teams/join" method="POST">
                        <input type="text" name="invite_code" placeholder="Enter Invite Code" required>
                        <button type="submit" class="btn" style="margin-top: 10px;">Join Team</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
