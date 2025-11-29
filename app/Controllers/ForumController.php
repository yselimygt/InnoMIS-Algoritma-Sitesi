<?php

require_once __DIR__ . '/../Models/ForumModel.php';
require_once __DIR__ . '/../Models/NotificationModel.php';

class ForumController extends Controller
{
    private $forumModel;
    private $notificationModel;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $this->forumModel = new ForumModel();
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        $threads = $this->forumModel->getThreads(50, 0);
        $this->view('forum/index', ['threads' => $threads]);
    }

    public function show($slug)
    {
        $thread = $this->forumModel->getThreadBySlug($slug);
        if (!$thread) {
            http_response_code(404);
            die("Başlık bulunamadı");
        }
        $comments = $this->forumModel->getComments($thread['id']);
        $this->view('forum/show', ['thread' => $thread, 'comments' => $comments]);
    }

    public function create()
    {
        $this->ensureAuth();
        $this->view('forum/create');
    }

    public function store()
    {
        $this->ensureAuth();

        $title = trim($_POST['title']);
        $body = trim($_POST['body']);
        $slug = $this->slugify($title);

        $this->forumModel->createThread($_SESSION['user_id'], $title, $slug, $body);
        $this->redirect('/forum/' . $slug);
    }

    public function comment($slug)
    {
        $this->ensureAuth();
        $thread = $this->forumModel->getThreadBySlug($slug);
        if (!$thread) {
            http_response_code(404);
            die("Başlık bulunamadı");
        }

        $body = trim($_POST['body']);
        $parentId = isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? (int)$_POST['parent_id'] : null;
        $this->forumModel->addComment($thread['id'], $_SESSION['user_id'], $body, $parentId);

        // Bildirim: yorum cevabı
        if ($parentId) {
            $parent = $this->forumModel->getCommentById($parentId);
            if ($parent && $parent['user_id'] != $_SESSION['user_id']) {
                $this->notificationModel->create(
                    $parent['user_id'],
                    'comment',
                    'Yorumuna yanıt geldi',
                    'Yorumuna yeni bir yanıt eklendi.',
                    APP_URL . '/forum/' . $slug
                );
            }
        } elseif ($thread['user_id'] != $_SESSION['user_id']) {
            // Eğer doğrudan konuya yorum yapıldıysa konu sahibine bilgi ver
            $this->notificationModel->create(
                $thread['user_id'],
                'comment',
                'Konuya yorum geldi',
                'Açtığın konuya yeni bir yorum yapıldı.',
                APP_URL . '/forum/' . $slug
            );
        }

        $this->redirect('/forum/' . $slug);
    }

    private function ensureAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    private function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return uniqid('baslik-');
        }
        return $text;
    }
}
