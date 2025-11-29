<?php

class NotificationModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($userId, $type, $title, $message, $link = null) {
        $sql = "INSERT INTO notifications (user_id, type, title, message, link)
                VALUES (:user_id, :type, :title, :message, :link)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link
        ]);
    }

    public function getUnread($userId, $limit = 10) {
        $sql = "SELECT * FROM notifications 
                WHERE user_id = :user_id AND is_read = 0
                ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function markAsRead($userId, $id) {
        $sql = "UPDATE notifications SET is_read = 1 WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }

    public function markAllRead($userId) {
        $sql = "UPDATE notifications SET is_read = 1 WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
    }
}
