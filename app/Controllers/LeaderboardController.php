<?php

class LeaderboardController extends Controller
{
    public function index()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT id, name, surname, xp, level, avatar FROM users ORDER BY xp DESC LIMIT 50");
        $users = $stmt->fetchAll();

        $viewerId = $_SESSION['user_id'] ?? null;
        $followingIds = [];
        if ($viewerId) {
            $followStmt = $db->prepare("SELECT followee_id FROM user_follows WHERE follower_id = :id");
            $followStmt->execute(['id' => $viewerId]);
            $followingIds = array_map('intval', $followStmt->fetchAll(PDO::FETCH_COLUMN));
        }

        $this->view('leaderboard/index', [
            'users' => $users,
            'viewerId' => $viewerId,
            'followingIds' => $followingIds
        ]);
    }

    public function api()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT id, name, surname, xp, level, avatar FROM users ORDER BY xp DESC LIMIT 50");
        $users = $stmt->fetchAll();

        header('Content-Type: application/json');
        echo json_encode($users);
    }
}
