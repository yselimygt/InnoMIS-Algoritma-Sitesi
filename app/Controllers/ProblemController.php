<?php

require_once __DIR__ . '/../Models/ProblemModel.php';
require_once __DIR__ . '/../../core/Sandbox.php';

class ProblemController extends Controller {
    public function index() {
        $model = new ProblemModel();
        $problems = $model->getAll();
        $this->view('problems/index', ['problems' => $problems]);
    }

    public function show($slug) {
        $model = new ProblemModel();
        $problem = $model->getBySlug($slug);
        
        if (!$problem) {
            die("Problem not found");
        }

        $this->view('problems/show', ['problem' => $problem]);
    }

    public function submit() {
        // API endpoint for submission
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        $slug = $input['slug'];
        $language = $input['language'];
        $code = $input['code'];
        
        // Mock user ID for now, should be from session
        session_start();
        $userId = $_SESSION['user_id'] ?? 1; 

        $model = new ProblemModel();
        $problem = $model->getBySlug($slug);
        $testCases = $model->getTestCases($problem['id']);
        
        $sandbox = new Sandbox();
        $finalResult = 'AC';
        $maxTime = 0;

        foreach ($testCases as $case) {
            $run = $sandbox->run($language, $code, $case['input']);
            
            if ($run['status'] != 'AC') {
                $finalResult = $run['status']; // CE or RE
                break;
            }
            
            if (trim($run['output']) !== trim($case['output'])) {
                $finalResult = 'WA';
                break;
            }
            
            if ($run['time'] > $maxTime) $maxTime = $run['time'];
        }

        $model->saveSubmission($userId, $problem['id'], $language, $code, $finalResult, $maxTime);

        if ($finalResult == 'AC') {
            require_once __DIR__ . '/../Services/GamificationService.php';
            $gamification = new GamificationService();
            
            // Calculate XP based on difficulty
            $xp = 10; // Default Easy
            if ($problem['difficulty'] == 'medium') $xp = 20;
            if ($problem['difficulty'] == 'hard') $xp = 30;
            
            $gamification->addXp($userId, $xp);
            
            // Check for First Solve Badge
            $submissionCount = $model->getUserSubmissionCount($userId);
            if ($submissionCount == 1) { // This is the first one (since we just saved it)
                $gamification->awardBadge($userId, 'first-solve');
            }
        }

        echo json_encode(['result' => $finalResult, 'time' => $maxTime]);
    }
}
