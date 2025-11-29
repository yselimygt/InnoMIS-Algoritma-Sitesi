<?php

require_once __DIR__ . '/../Models/FollowModel.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/NotificationModel.php';

class FollowController extends Controller
{
    private $followModel;
    private $userModel;
    private $notificationModel;

    public function __construct()
    {
        session_start();
        $this->followModel = new FollowModel();
        $this->userModel = new UserModel();
        $this->notificationModel = new NotificationModel();
    }

    public function follow()
    {
        $this->ensureLoggedIn();
        $targetId = (int) ($_POST['user_id'] ?? 0);
        $redirectTo = $this->sanitizeRedirect($_POST['redirect_to'] ?? null, $targetId);
        $currentUserId = (int) $_SESSION['user_id'];

        if ($targetId <= 0 || $targetId === $currentUserId) {
            $this->redirect($redirectTo);
        }

        $created = $this->followModel->follow($currentUserId, $targetId);
        if ($created) {
            $follower = $this->userModel->findById($currentUserId);
            if ($follower) {
                $title = 'Yeni Takipçi';
                $message = $follower['name'] . ' ' . $follower['surname'] . ' seni takip etmeye başladı.';
                $link = APP_URL . '/profile/' . $currentUserId;
                $this->notificationModel->create($targetId, 'system', $title, $message, $link);
            }
        }

        $this->redirect($redirectTo);
    }

    public function unfollow()
    {
        $this->ensureLoggedIn();
        $targetId = (int) ($_POST['user_id'] ?? 0);
        $redirectTo = $this->sanitizeRedirect($_POST['redirect_to'] ?? null, $targetId);
        $currentUserId = (int) $_SESSION['user_id'];

        if ($targetId <= 0 || $targetId === $currentUserId) {
            $this->redirect($redirectTo);
        }

        $this->followModel->unfollow($currentUserId, $targetId);
        $this->redirect($redirectTo);
    }

    private function ensureLoggedIn(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    private function sanitizeRedirect(?string $value, int $fallbackUserId): string
    {
        // Gelen değer dolu mu kontrol et
        if ($value) {
            // Eğer değer tam URL içeriyorsa (APP_URL), onu temizle
            $basePath = parse_url(APP_URL, PHP_URL_PATH); // "/InnoMIS-Algoritma-Sitesi/public_html" kısmını alır
            
            // Eğer gelen değer base path ile başlıyorsa, o kısmı sil
            if ($basePath && strpos($value, $basePath) === 0) {
                $value = substr($value, strlen($basePath));
            }
            
            // Sadece '/' ile başlıyorsa geçerli say
            if (strpos($value, '/') === 0) {
                return $value;
            }
        }
        
        return '/profile/' . $fallbackUserId;
    }
}
