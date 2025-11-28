<?php

class BadgeModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM badges");
        return $stmt->fetchAll();
    }

    public function getUserBadges($userId) {
        $sql = "SELECT b.* FROM badges b 
                JOIN user_badges ub ON b.id = ub.badge_id 
                WHERE ub.user_id = :uid";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public function create($name, $description, $iconPath) {
        $sql = "INSERT INTO badges (name, description, icon_path) VALUES (:name, :desc, :icon)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['name' => $name, 'desc' => $description, 'icon' => $iconPath]);
    }
}
