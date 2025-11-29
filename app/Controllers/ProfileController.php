<?php

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/BadgeModel.php';
require_once __DIR__ . '/../Models/ProblemModel.php';
require_once __DIR__ . '/../Models/FollowModel.php';

class ProfileController extends Controller
{
    private $userModel;
    private $badgeModel;
    private $problemModel;
    private $followModel;

    public function __construct()
    {
        session_start();
        $this->userModel = new UserModel();
        $this->badgeModel = new BadgeModel();
        $this->problemModel = new ProblemModel();
        $this->followModel = new FollowModel();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $viewerId = (int) $_SESSION['user_id'];
        $this->renderProfile($viewerId, $viewerId);
    }

    public function show($id)
    {
        $profileUserId = (int) $id;
        $viewerId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
        $this->renderProfile($profileUserId, $viewerId);
    }

    private function renderProfile(int $profileUserId, ?int $viewerId): void
    {
        $user = $this->userModel->findById($profileUserId);

        if (!$user) {
            if ($viewerId !== null && $viewerId === $profileUserId) {
                session_destroy();
                $this->redirect('/login');
                return;
            }
            http_response_code(404);
            echo "Kullanıcı bulunamadı";
            return;
        }

        $badges = $this->badgeModel->getUserBadges($profileUserId);
        $submissions = $this->problemModel->getUserSubmissions($profileUserId);
        $followStats = $this->followModel->getStats($profileUserId);
        $followerList = $this->followModel->getFollowers($profileUserId, 6);
        $followingList = $this->followModel->getFollowing($profileUserId, 6);

        $isSelf = $viewerId !== null && $viewerId === $profileUserId;
        $isFollowing = false;
        if ($viewerId !== null && !$isSelf) {
            $isFollowing = $this->followModel->isFollowing($viewerId, $profileUserId);
        }

        $this->view('profile/index', [
            'profileUser' => $user,
            'viewerId' => $viewerId,
            'isSelf' => $isSelf,
            'isFollowing' => $isFollowing,
            'followStats' => $followStats,
            'followers' => $followerList,
            'following' => $followingList,
            'badges' => $badges,
            'submissions' => $submissions
        ]);
    }
}
