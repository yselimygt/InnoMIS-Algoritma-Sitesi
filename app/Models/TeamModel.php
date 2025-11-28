<?php

class TeamModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getUserTeam($userId) {
        $sql = "SELECT t.*, CONCAT(u.name, ' ', u.surname) as creator_name 
                FROM teams t 
                JOIN team_members tm ON t.id = tm.team_id 
                JOIN users u ON t.leader_id = u.id
                WHERE tm.user_id = :uid";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetch();
    }

    public function getTeamMembers($teamId) {
        $sql = "SELECT u.name, u.surname, u.level, u.xp, tm.joined_at 
                FROM team_members tm 
                JOIN users u ON tm.user_id = u.id 
                WHERE tm.team_id = :tid";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['tid' => $teamId]);
        return $stmt->fetchAll();
    }

    public function createTeam($name, $description, $leaderId) {
        $inviteCode = substr(md5(uniqid()), 0, 8);
        
        try {
            $this->db->beginTransaction();
            
            $sql = "INSERT INTO teams (name, description, leader_id, invite_code) VALUES (:name, :desc, :lid, :code)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['name' => $name, 'desc' => $description, 'lid' => $leaderId, 'code' => $inviteCode]);
            
            $teamId = $this->db->lastInsertId();
            
            $sqlMember = "INSERT INTO team_members (team_id, user_id) VALUES (:tid, :uid)";
            $stmtMember = $this->db->prepare($sqlMember);
            $stmtMember->execute(['tid' => $teamId, 'uid' => $leaderId]);
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function joinTeam($inviteCode, $userId) {
        $sql = "SELECT id FROM teams WHERE invite_code = :code";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code' => $inviteCode]);
        $team = $stmt->fetch();
        
        if ($team) {
            try {
                $sqlMember = "INSERT INTO team_members (team_id, user_id) VALUES (:tid, :uid)";
                $stmtMember = $this->db->prepare($sqlMember);
                $stmtMember->execute(['tid' => $team['id'], 'uid' => $userId]);
                return true;
            } catch (Exception $e) {
                return false; // Already member
            }
        }
        return false;
    }
}
