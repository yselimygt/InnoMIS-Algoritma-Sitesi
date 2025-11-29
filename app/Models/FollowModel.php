<?php

class FollowModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function follow(int $followerId, int $followeeId): bool
    {
        if ($followerId === $followeeId) {
            return false;
        }
        $sql = "INSERT IGNORE INTO user_follows (follower_id, followee_id) VALUES (:follower, :followee)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'follower' => $followerId,
            'followee' => $followeeId,
        ]);
        return $stmt->rowCount() > 0;
    }

    public function unfollow(int $followerId, int $followeeId): void
    {
        $sql = "DELETE FROM user_follows WHERE follower_id = :follower AND followee_id = :followee";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'follower' => $followerId,
            'followee' => $followeeId,
        ]);
    }

    public function isFollowing(int $followerId, int $followeeId): bool
    {
        $sql = "SELECT 1 FROM user_follows WHERE follower_id = :follower AND followee_id = :followee";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'follower' => $followerId,
            'followee' => $followeeId,
        ]);
        return (bool) $stmt->fetchColumn();
    }

    public function getStats(int $userId): array
    {
        $followers = $this->countFollowers($userId);
        $following = $this->countFollowing($userId);
        return [
            'followers' => $followers,
            'following' => $following,
        ];
    }

    public function countFollowers(int $userId): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM user_follows WHERE followee_id = :id");
        $stmt->execute(['id' => $userId]);
        return (int) $stmt->fetchColumn();
    }

    public function countFollowing(int $userId): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM user_follows WHERE follower_id = :id");
        $stmt->execute(['id' => $userId]);
        return (int) $stmt->fetchColumn();
    }

    public function getFollowers(int $userId, int $limit = 6): array
    {
        $sql = "SELECT u.id, u.name, u.surname FROM user_follows f
                INNER JOIN users u ON u.id = f.follower_id
                WHERE f.followee_id = :id
                ORDER BY f.created_at DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFollowing(int $userId, int $limit = 6): array
    {
        $sql = "SELECT u.id, u.name, u.surname FROM user_follows f
                INNER JOIN users u ON u.id = f.followee_id
                WHERE f.follower_id = :id
                ORDER BY f.created_at DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFollowingIds(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT followee_id FROM user_follows WHERE follower_id = :id");
        $stmt->execute(['id' => $userId]);
        return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }
}
