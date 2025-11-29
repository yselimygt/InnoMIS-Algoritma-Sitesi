<?php

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/BadgeModel.php';
require_once __DIR__ . '/../Models/ProblemModel.php';

class ProfileController extends Controller {
    public function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $userId = $_SESSION['user_id'];
        
        $userModel = new UserModel();
        $user = $userModel->findById($userId);

        // Oturum var ama kullanıcı kaydı yoksa (örn. veritabanı sıfırlandıysa) yeniden girişe yönlendir
        if (!$user) {
            session_destroy();
            $this->redirect('/login');
        }
        
        $badgeModel = new BadgeModel();
        $badges = $badgeModel->getUserBadges($userId);
        
        $problemModel = new ProblemModel();
        $submissions = $problemModel->getUserSubmissions($userId);
        
        $this->view('profile/index', [
            'user' => $user,
            'badges' => $badges,
            'submissions' => $submissions
        ]);
    }
}
