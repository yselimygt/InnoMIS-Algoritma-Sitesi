<?php

require_once __DIR__ . '/../Models/UserModel.php';

class GamificationService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addXp($userId, $amount) {
        $userModel = new UserModel();
        // We need to fetch current XP first, but UserModel doesn't have findById yet.
        // Let's add a quick query here or assume we can update directly.
        
        $sql = "UPDATE users SET xp = xp + :amount WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['amount' => $amount, 'id' => $userId]);

        $this->checkLevelUp($userId);
    }

    private function checkLevelUp($userId) {
        $sql = "SELECT xp, level FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch();

        if ($user) {
            $newLevel = floor($user['xp'] / 120) + 1;
            if ($newLevel > $user['level']) {
                $updateSql = "UPDATE users SET level = :level WHERE id = :id";
                $updateStmt = $this->db->prepare($updateSql);
                $updateStmt->execute(['level' => $newLevel, 'id' => $userId]);
                
                // Trigger Level Up Badge Check or Notification here
            }
        }
    }

    public function awardBadge($userId, $badgeSlug) {
        // Check if user already has badge
        $checkSql = "SELECT id FROM user_badges WHERE user_id = :uid AND badge_id = (SELECT id FROM badges WHERE slug = :slug)";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute(['uid' => $userId, 'slug' => $badgeSlug]);
        
        if ($checkStmt->rowCount() == 0) {
            $sql = "INSERT INTO user_badges (user_id, badge_id, granted_at) 
                    SELECT :uid, id, NOW() FROM badges WHERE slug = :slug";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['uid' => $userId, 'slug' => $badgeSlug]);
            return true;
        }
        return false;
    }
}
