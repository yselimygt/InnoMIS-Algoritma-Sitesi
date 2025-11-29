<?php

require_once __DIR__ . '/../Models/NotificationModel.php';

class NotificationController extends Controller {
    private $notificationModel;

    public function __construct() {
        session_start();
        $this->notificationModel = new NotificationModel();
    }

    public function markRead() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            die('Giriş gerekli');
        }
        $id = $_POST['id'];
        $this->notificationModel->markAsRead($_SESSION['user_id'], $id);
        echo json_encode(['status' => 'ok']);
    }

    public function markAll() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            die('Giriş gerekli');
        }
        $this->notificationModel->markAllRead($_SESSION['user_id']);
        echo json_encode(['status' => 'ok']);
    }
}
