<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tournament - Admin</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Create Tournament</h1>
        <div class="card">
            <form action="<?= APP_URL ?>/admin/tournaments/store" method="POST">
                <label>Title</label>
                <input type="text" name="title" required>
                
                <label>Description</label>
                <textarea name="description" rows="3"></textarea>
                
                <label>Start Time</label>
                <input type="datetime-local" name="start_time" required style="background: #333; color: #fff; border: 1px solid #555; padding: 10px; width: 100%; margin-bottom: 10px;">
                
                <label>End Time</label>
                <input type="datetime-local" name="end_time" required style="background: #333; color: #fff; border: 1px solid #555; padding: 10px; width: 100%; margin-bottom: 10px;">
                
                <button type="submit" class="btn">Create Tournament</button>
            </form>
        </div>
    </div>
</body>
</html>
