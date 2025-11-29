<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($thread['title']) ?> - Forum</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . '/../partials/navbar.php'; ?>
    <div class="container">
        <a href="<?= APP_URL ?>/forum" style="color:#b0b8c4;">← Forum</a>
        <h1><?= htmlspecialchars($thread['title']) ?></h1>
        <div class="card" style="margin-bottom:20px;">
            <div style="font-size:0.9rem; color:#b0b8c4; margin-bottom:10px;">
                <?= htmlspecialchars($thread['name'] . ' ' . $thread['surname']) ?> • <?= $thread['created_at'] ?>
            </div>
            <div><?= nl2br(htmlspecialchars($thread['body'])) ?></div>
        </div>

        <h3>Yorumlar</h3>
        <div class="card">
            <?php if (empty($comments)): ?>
                <p>Henüz yorum yok.</p>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div style="border-bottom: 1px solid rgba(255,255,255,0.08); padding:10px 0;">
                        <div style="font-size:0.9rem; color:#b0b8c4;">
                            <?= htmlspecialchars($comment['name'] . ' ' . $comment['surname']) ?> • <?= $comment['created_at'] ?>
                        </div>
                        <div><?= nl2br(htmlspecialchars($comment['body'])) ?></div>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button type="button" class="btn btn-secondary" style="margin-top:6px; padding:4px 8px; font-size:0.85rem;"
                                onclick="setReply(<?= $comment['id'] ?>, '<?= htmlspecialchars($comment['name'] . ' ' . $comment['surname'], ENT_QUOTES) ?>')">
                                Cevapla
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="<?= APP_URL ?>/forum/<?= $thread['slug'] ?>/yorum" method="POST" style="margin-top:20px;">
                <div class="card">
                    <label>Yorumun</label>
                    <input type="hidden" name="parent_id" id="parent_id" value="">
                    <div id="replying-to" style="display:none; font-size:0.9rem; color:#b0b8c4; margin-bottom:6px;"></div>
                    <textarea name="body" rows="4" required></textarea>
                    <button type="submit" class="btn" style="margin-top:10px;">Gönder</button>
                    <button type="button" class="btn btn-secondary" style="margin-top:10px;" onclick="clearReply()">Cevabı Temizle</button>
                </div>
            </form>
        <?php else: ?>
            <p>Yorum yapmak için <a href="<?= APP_URL ?>/login">giriş yap</a>.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<script>
    function setReply(id, name) {
        const input = document.getElementById('parent_id');
        const label = document.getElementById('replying-to');
        input.value = id;
        label.style.display = 'block';
        label.innerText = name + ' kullanıcısına yanıt veriyorsun';
    }
    function clearReply() {
        const input = document.getElementById('parent_id');
        const label = document.getElementById('replying-to');
        input.value = '';
        label.style.display = 'none';
        label.innerText = '';
    }
</script>
