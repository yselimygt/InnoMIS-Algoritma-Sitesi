<?php

require_once __DIR__ . '/../Models/ProblemModel.php';
require_once __DIR__ . '/../Models/BadgeModel.php';

class AdminController extends Controller {
    
    public function __construct() {
        // Simple Admin Check
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            die("Access Denied");
        }
    }

    public function index() {
        $this->view('admin/dashboard');
    }

    public function problems() {
        $model = new ProblemModel();
        $problems = $model->getAll(); // Should probably be a different method fetching all including inactive
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
<?php

require_once __DIR__ . '/../Models/ProblemModel.php';
require_once __DIR__ . '/../Models/BadgeModel.php';
require_once __DIR__ . '/../Models/UserModel.php'; // Added for UserModel

class AdminController extends Controller {
    
    public function __construct() {
        // Simple Admin Check
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            die("Access Denied");
        }
    }

    public function index() {
        $this->view('admin/dashboard');
    }

    public function problems() {
        $model = new ProblemModel();
        $problems = $model->getAll(); // Should probably be a different method fetching all including inactive
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
            // Handle error (e.g. slug exists)
            die("Error creating problem. Slug might be duplicate.");
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
        $iconPath = 'default_badge.png'; // Simplify for now, or handle upload

        // Handle File Upload
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../public/uploads/badges/';
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
        require_once __DIR__ . '/../Models/TournamentModel.php';
        $model = new TournamentModel();
        $tournaments = $model->getAll();
        $this->view('admin/tournaments/index', ['tournaments' => $tournaments]);
    }

    public function createTournament() {
        $this->view('admin/tournaments/create');
    }

    public function storeTournament() {
        require_once __DIR__ . '/../Models/TournamentModel.php';
        $title = $_POST['title'];
        $description = $_POST['description'];
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];
        
        $model = new TournamentModel();
        $model->create($title, $description, $startTime, $endTime);
        
        $this->redirect('/admin/tournaments');
    }
}
