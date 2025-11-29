<?php

require_once __DIR__ . '/../Models/ProblemModel.php';
require_once __DIR__ . '/../Models/BadgeModel.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/TournamentModel.php';
require_once __DIR__ . '/../Models/ForumModel.php';

class AdminController extends Controller {
    
   public function __construct() {
        // Oturum zaten başlatılmamışsa başlat
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
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
        $problems = $model->getAll(false);
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
            'slug' => $_POST['slug'] ?: $this->slugify($_POST['title']),
            'description' => $_POST['description'],
            'input_format' => $_POST['input_format'],
            'output_format' => $_POST['output_format'],
            'difficulty' => $_POST['difficulty'],
            'tags' => $_POST['tags'],
            'is_active' => isset($_POST['is_active']) ? 1 : 0
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

    public function editProblem($id) {
        $model = new ProblemModel();
        $problem = $model->getById($id);
        $cases = $model->getTestCases($id);
        if (!$problem) {
            die("Problem bulunamadı");
        }
        $this->view('admin/problems/edit', ['problem' => $problem, 'cases' => $cases]);
    }

    public function updateProblem() {
        $id = $_POST['id'];
        $model = new ProblemModel();
        $problem = $model->getById($id);
        if (!$problem) {
            die("Problem bulunamadı");
        }

        $data = [
            'title' => $_POST['title'],
            'slug' => $_POST['slug'] ?: $this->slugify($_POST['title']),
            'description' => $_POST['description'],
            'input_format' => $_POST['input_format'],
            'output_format' => $_POST['output_format'],
            'difficulty' => $_POST['difficulty'],
            'tags' => $_POST['tags'],
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        $model->update($id, $data);

        // İsteğe bağlı yeni test case ekle
        if (!empty($_POST['test_cases'])) {
            foreach ($_POST['test_cases'] as $case) {
                if (trim($case['input']) !== '' || trim($case['output']) !== '') {
                    $model->addTestCase($id, $case);
                }
            }
        }

        $this->redirect('/admin/problems');
    }

    public function deleteProblem() {
        $id = $_POST['id'];
        $model = new ProblemModel();
        $model->delete($id);
        $this->redirect('/admin/problems');
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
        $type = $_POST['type'];
        $rarity = $_POST['rarity'];
        $slug = $_POST['slug'] ?: $this->slugify($name);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

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
        $badgeModel->create([
            'slug' => $slug,
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'rarity' => $rarity,
            'icon_path' => $iconPath,
            'is_active' => $isActive
        ]);
        
        $this->redirect('/admin/badges');
    }

    public function editBadge($id) {
        $badgeModel = new BadgeModel();
        $badge = $badgeModel->getById($id);
        if (!$badge) die("Rozet bulunamadı");
        $this->view('admin/badges/edit', ['badge' => $badge]);
    }

    public function updateBadge() {
        $id = $_POST['id'];
        $badgeModel = new BadgeModel();
        $badge = $badgeModel->getById($id);
        if (!$badge) die("Rozet bulunamadı");

        $iconPath = $badge['icon_path'];
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../public_html/uploads/badges/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $fileName = uniqid() . '_' . basename($_FILES['icon']['name']);
            if (move_uploaded_file($_FILES['icon']['tmp_name'], $uploadDir . $fileName)) {
                $iconPath = $fileName;
            }
        }

        $badgeModel->update($id, [
            'slug' => $_POST['slug'] ?: $this->slugify($_POST['name']),
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'type' => $_POST['type'],
            'rarity' => $_POST['rarity'],
            'icon_path' => $iconPath,
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ]);

        $this->redirect('/admin/badges');
    }

    public function deleteBadge() {
        $id = $_POST['id'];
        $badgeModel = new BadgeModel();
        $badgeModel->delete($id);
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

    public function editTournament($id) {
        $model = new TournamentModel();
        $tournament = $model->getById($id);
        if (!$tournament) die("Turnuva bulunamadı");
        $this->view('admin/tournaments/edit', ['tournament' => $tournament]);
    }

    public function updateTournament() {
        $id = $_POST['id'];
        $model = new TournamentModel();
        $model->update(
            $id,
            $_POST['title'],
            $_POST['description'],
            $_POST['start_time'],
            $_POST['end_time'],
            isset($_POST['is_active']) ? 1 : 0
        );
        $this->redirect('/admin/tournaments');
    }

    public function deleteTournament() {
        $id = $_POST['id'];
        $model = new TournamentModel();
        $model->delete($id);
        $this->redirect('/admin/tournaments');
    }

    public function deleteUser() {
        $userId = $_POST['user_id'];
        if ($userId == $_SESSION['user_id']) {
            die("Kendi hesabınızı silemezsiniz.");
        }
        $userModel = new UserModel();
        $userModel->delete($userId);
        $this->redirect('/admin/users');
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

    public function deleteThread() {
        $id = $_POST['thread_id'];
        $forum = new ForumModel();
        $forum->deleteThread($id);
        $this->redirect('/admin/forum');
    }

    private function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return uniqid('item-');
        }
        return $text;
    }
}
