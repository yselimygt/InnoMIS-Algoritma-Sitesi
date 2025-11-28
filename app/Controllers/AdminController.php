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
}
