<?php

class ForumModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getThreads($limit = 20, $offset = 0) {
        $sql = "SELECT ft.*, u.name, u.surname 
                FROM forum_threads ft
                JOIN users u ON u.id = ft.user_id
                WHERE ft.is_deleted = 0
                ORDER BY ft.is_pinned DESC, ft.last_comment_at DESC, ft.created_at DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getThreadBySlug($slug) {
        $sql = "SELECT ft.*, u.name, u.surname 
                FROM forum_threads ft
                JOIN users u ON u.id = ft.user_id
                WHERE ft.slug = :slug AND ft.is_deleted = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    public function getAllThreadsForAdmin() {
        $sql = "SELECT ft.*, u.name, u.surname 
                FROM forum_threads ft
                JOIN users u ON u.id = ft.user_id
                ORDER BY ft.created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function createThread($userId, $title, $slug, $body) {
        $sql = "INSERT INTO forum_threads (user_id, title, slug, body, last_comment_at)
                VALUES (:user_id, :title, :slug, :body, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'slug' => $slug,
            'body' => $body
        ]);
    }

    public function addComment($threadId, $userId, $body, $parentId = null) {
        $sql = "INSERT INTO forum_comments (thread_id, user_id, body, parent_id)
                VALUES (:thread_id, :user_id, :body, :parent_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'thread_id' => $threadId,
            'user_id' => $userId,
            'body' => $body,
            'parent_id' => $parentId
        ]);

        // Update last comment timestamp
        $this->db->prepare("UPDATE forum_threads SET last_comment_at = NOW() WHERE id = :id")
            ->execute(['id' => $threadId]);
    }

    public function getCommentById($id) {
        $sql = "SELECT * FROM forum_comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getComments($threadId) {
        $sql = "SELECT fc.*, u.name, u.surname 
                FROM forum_comments fc
                JOIN users u ON u.id = fc.user_id
                WHERE fc.thread_id = :thread_id AND fc.is_deleted = 0
                ORDER BY fc.created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['thread_id' => $threadId]);
        return $stmt->fetchAll();
    }

    public function setThreadVisibility($threadId, $isDeleted) {
        $stmt = $this->db->prepare("UPDATE forum_threads SET is_deleted = :del WHERE id = :id");
        $stmt->execute(['del' => $isDeleted ? 1 : 0, 'id' => $threadId]);
    }
}
