<?php

class LeaderboardController extends Controller {
    public function index() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT name, surname, xp, level, avatar FROM users ORDER BY xp DESC LIMIT 50");
        $users = $stmt->fetchAll();

        $this->view('leaderboard/index', ['users' => $users]);
    }
}
