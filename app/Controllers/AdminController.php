<?php

require_once __DIR__ . '/../Models/ProblemModel.php';
require_once __DIR__ . '/../Models/BadgeModel.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/TournamentModel.php';
require_once __DIR__ . '/../Models/ForumModel.php';

class AdminController extends Controller {
    
    public function __construct() {
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            die("Access Denied");
        }
    }

    public function index() {
        $stats = $this->getStats();
        $this->view('admin/dashboard', ['stats' => $stats]);
    }

    private function getStats() {
        $db = Database::getInstance()->getConnection();
        $counts = [];
        $counts['users'] = $db->query("SELECT COUNT(*) AS c FROM users")->fetch()['c'];
        $counts['problems'] = $db->query("SELECT COUNT(*) AS c FROM problems")->fetch()['c'];
        $counts['submissions'] = $db->query("SELECT COUNT(*) AS c FROM submissions")->fetch()['c'];
        $counts['threads'] = $db->query("SELECT COUNT(*) AS c FROM forum_threads")->fetch()['c'];
        return $counts;
    }

    public function problems() {
        $model = new ProblemModel();
        $problems = $model->getAll();
        $this->view('admin/problems/index', ['problems' => $problems]);
    }

    public function createProblem() {
        $this->view('admin/problems/create');
    }

    public function storeProblem() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/problems/create');
        }

        $problemData = [
            'title' => $_POST['title'],
            'slug' => $_POST['slug'],
            'description' => $_POST['description'],
            'input_format' => $_POST['input_format'],
            'output_format' => $_POST['output_format'],
            'difficulty' => $_POST['difficulty'],
            'tags' => $_POST['tags']
        ];

        $testCases = $_POST['test_cases'] ?? [];

        $model = new ProblemModel();
        $problemId = $model->create($problemData);

        if ($problemId) {
            foreach ($testCases as $case) {
                $model->addTestCase($problemId, $case);
            }
            $this->redirect('/admin/problems');
        } else {
            die("Problem oluşturulamadı. Slug çakışıyor olabilir.");
        }
    }

    public function manageUsers() {
        $userModel = new UserModel();
        $users = $userModel->getAll();
        $this->view('admin/users/index', ['users' => $users]);
    }

    public function updateUserRole() {
        $userId = $_POST['user_id'];
        $role = $_POST['role'];
        
        $userModel = new UserModel();
        $userModel->updateRole($userId, $role);
        
        $this->redirect('/admin/users');
    }

    public function manageBadges() {
        $badgeModel = new BadgeModel();
        $badges = $badgeModel->getAll();
        $this->view('admin/badges/index', ['badges' => $badges]);
    }

    public function createBadge() {
        $this->view('admin/badges/create');
    }

    public function storeBadge() {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $iconPath = 'default_badge.png';

        if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../public_html/uploads/badges/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $fileName = uniqid() . '_' . basename($_FILES['icon']['name']);
            if (move_uploaded_file($_FILES['icon']['tmp_name'], $uploadDir . $fileName)) {
                $iconPath = $fileName;
            }
        }

        $badgeModel = new BadgeModel();
        $badgeModel->create($name, $description, $iconPath);
        
        $this->redirect('/admin/badges');
    }

    public function manageTournaments() {
        $model = new TournamentModel();
        $tournaments = $model->getAll();
        $this->view('admin/tournaments/index', ['tournaments' => $tournaments]);
    }

    public function createTournament() {
        $this->view('admin/tournaments/create');
    }

    public function storeTournament() {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];
        
        $model = new TournamentModel();
        $model->create($title, $description, $startTime, $endTime);
        
        $this->redirect('/admin/tournaments');
    }

    public function forumThreads() {
        $forum = new ForumModel();
        $threads = $forum->getAllThreadsForAdmin();
        $this->view('admin/forum/index', ['threads' => $threads]);
    }

    public function toggleThread() {
        $threadId = $_POST['thread_id'];
        $hide = isset($_POST['hide']) ? (bool)$_POST['hide'] : false;
        $forum = new ForumModel();
        $forum->setThreadVisibility($threadId, $hide);
        $this->redirect('/admin/forum');
    }
}
