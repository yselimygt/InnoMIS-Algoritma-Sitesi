<?php

class TournamentModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM tournaments ORDER BY start_time DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tournaments WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getParticipants($tournamentId) {
        $sql = "SELECT u.name, u.surname, u.level, tp.score 
                FROM tournament_participants tp 
                JOIN users u ON tp.user_id = u.id 
                WHERE tp.tournament_id = :tid 
                ORDER BY tp.score DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['tid' => $tournamentId]);
        return $stmt->fetchAll();
    }

    public function joinTournament($tournamentId, $userId) {
        // Check if already joined
        $checkSql = "SELECT id FROM tournament_participants WHERE tournament_id = :tid AND user_id = :uid";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute(['tid' => $tournamentId, 'uid' => $userId]);
        
        if ($checkStmt->rowCount() > 0) {
            return false;
        }

        $sql = "INSERT INTO tournament_participants (tournament_id, user_id) VALUES (:tid, :uid)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['tid' => $tournamentId, 'uid' => $userId]);
    }

    public function create($title, $description, $startTime, $endTime) {
        $sql = "INSERT INTO tournaments (title, description, start_time, end_time, is_active) 
                VALUES (:title, :desc, :start, :end, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'desc' => $description,
            'start' => $startTime,
            'end' => $endTime
        ]);
    }

    public function update($id, $title, $description, $startTime, $endTime, $isActive) {
        $sql = "UPDATE tournaments SET title = :title, description = :desc, start_time = :start, end_time = :end, is_active = :active WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'desc' => $description,
            'start' => $startTime,
            'end' => $endTime,
            'active' => $isActive ? 1 : 0,
            'id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tournaments WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
