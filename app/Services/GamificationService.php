<?php

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/NotificationModel.php';

class GamificationService {
    private $db;
    private $notificationModel;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->notificationModel = new NotificationModel();
    }

    public function addXp($userId, $amount) {
        $userModel = new UserModel();
        // XP güncelle
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
                
                // Bildirim: seviye atlama
                $this->notificationModel->create(
                    $userId,
                    'system',
                    'Seviye Atlama',
                    "Tebrikler! Seviye {$newLevel}'a ulaştın.",
                    APP_URL . '/profile'
                );
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

            // Bildirim: rozet
            $this->notificationModel->create(
                $userId,
                'badge',
                'Yeni Rozet',
                "Yeni bir rozet kazandın: {$badgeSlug}",
                APP_URL . '/profile'
            );
            return true;
        }
        return false;
    }
}
