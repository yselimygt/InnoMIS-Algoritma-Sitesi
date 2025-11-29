<?php

require_once __DIR__ . '/../Models/LearningPathModel.php';
require_once __DIR__ . '/../Models/UserPathProgressModel.php';
require_once __DIR__ . '/../Models/NotificationModel.php';

class LearningPathController extends Controller
{
    private $pathModel;
    private $progressModel;
    private $notificationModel;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $this->pathModel = new LearningPathModel();
        $this->progressModel = new UserPathProgressModel();
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        $paths = $this->pathModel->getAll();
        $userId = $_SESSION['user_id'] ?? null;
        $progressMap = [];
        if ($userId) {
            $ids = array_column($paths, 'id');
            $progressMap = $this->progressModel->getProgressMap((int) $userId, $ids);
        }

        $this->view('paths/index', [
            'paths' => $paths,
            'progressMap' => $progressMap,
            'viewerId' => $userId
        ]);
    }

    public function show($id)
    {
        $path = $this->pathModel->getById($id);
        if (!$path) {
            http_response_code(404);
            die('Öğrenme yolu bulunamadı');
        }

        $steps = $this->pathModel->getSteps($id);
        $userId = $_SESSION['user_id'] ?? null;
        $progressSummary = null;
        $completedSteps = [];
        if ($userId) {
            $progressSummary = $this->progressModel->getProgressSummary((int) $userId, (int) $id);
            $completedSteps = $this->progressModel->getCompletedStepIds((int) $userId, (int) $id);
        }

        $this->view('paths/show', [
            'path' => $path,
            'steps' => $steps,
            'viewerId' => $userId,
            'progressSummary' => $progressSummary,
            'completedSteps' => $completedSteps
        ]);
    }

    public function toggleStep($pathId)
    {
        $this->ensureAuth();
        $stepId = (int) ($_POST['step_id'] ?? 0);
        $complete = ($_POST['complete'] ?? '1') === '1';

        if ($stepId > 0) {
            $this->progressModel->setStepStatus((int) $_SESSION['user_id'], (int) $pathId, $stepId, $complete);
        }

        $this->redirect('/path/' . $pathId);
    }

    public function remind($pathId)
    {
        $this->ensureAuth();
        $path = $this->pathModel->getById($pathId);
        if ($path) {
            $this->notificationModel->create(
                $_SESSION['user_id'],
                'system',
                'Öğrenme yolu hatırlatıcısı',
                '"' . $path['title'] . '" yolundaki adımlarını tamamlamaya devam et!',
                APP_URL . '/path/' . $pathId
            );
        }
        $this->redirect('/path/' . $pathId);
    }

    private function ensureAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
}
