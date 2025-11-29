<?php

class BadgeModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM badges ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM badges WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getUserBadges($userId) {
        $sql = "SELECT b.name, b.description, b.icon_path, ub.granted_at 
                FROM badges b 
                JOIN user_badges ub ON b.id = ub.badge_id 
                WHERE ub.user_id = :uid";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO badges (slug, name, description, type, rarity, icon_path, is_active) 
                VALUES (:slug, :name, :description, :type, :rarity, :icon_path, :is_active)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }

    public function update($id, $data) {
        $sql = "UPDATE badges SET slug = :slug, name = :name, description = :description, 
                type = :type, rarity = :rarity, icon_path = :icon_path, is_active = :is_active 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM badges WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
