<?php

class UserPathProgressModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getProgressSummary(int $userId, int $pathId): array
    {
        $total = $this->countPathSteps($pathId);
        if ($total === 0) {
            return [
                'total' => 0,
                'completed' => 0,
                'percentage' => 0,
                'is_completed' => false,
            ];
        }

        $completed = $this->countCompletedSteps($userId, $pathId);
        $percentage = (int) round(($completed / $total) * 100);

        return [
            'total' => $total,
            'completed' => $completed,
            'percentage' => $percentage,
            'is_completed' => $completed >= $total && $total > 0,
        ];
    }

    public function getProgressMap(int $userId, array $pathIds): array
    {
        $map = [];
        foreach ($pathIds as $pathId) {
            $map[$pathId] = $this->getProgressSummary($userId, (int) $pathId);
        }
        return $map;
    }

    public function getCompletedStepIds(int $userId, int $pathId): array
    {
        $sql = "SELECT step_id FROM user_path_step_progress WHERE user_id = :user AND path_id = :path";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user' => $userId, 'path' => $pathId]);
        return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }

    public function setStepStatus(int $userId, int $pathId, int $stepId, bool $complete): bool
    {
        if (!$this->stepBelongsToPath($stepId, $pathId)) {
            return false;
        }

        if ($complete) {
            $sql = "INSERT INTO user_path_step_progress (user_id, path_id, step_id) VALUES (:user, :path, :step)
                    ON DUPLICATE KEY UPDATE completed_at = CURRENT_TIMESTAMP";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user' => $userId, 'path' => $pathId, 'step' => $stepId]);
        } else {
            $sql = "DELETE FROM user_path_step_progress WHERE user_id = :user AND step_id = :step";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user' => $userId, 'step' => $stepId]);
        }

        $this->refreshAggregate($userId, $pathId);
        return true;
    }

    private function refreshAggregate(int $userId, int $pathId): void
    {
        $total = $this->countPathSteps($pathId);
        $completed = $this->countCompletedSteps($userId, $pathId);
        $done = ($total > 0) && ($completed >= $total);

        $sql = "INSERT INTO user_path_progress (user_id, path_id, completed_steps, is_completed)
                VALUES (:user, :path, :completed, :done)
                ON DUPLICATE KEY UPDATE completed_steps = :completed, is_completed = :done, last_updated = CURRENT_TIMESTAMP";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user' => $userId,
            'path' => $pathId,
            'completed' => $completed,
            'done' => $done ? 1 : 0,
        ]);
    }

    private function countPathSteps(int $pathId): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM path_steps WHERE path_id = :path");
        $stmt->execute(['path' => $pathId]);
        return (int) $stmt->fetchColumn();
    }

    private function countCompletedSteps(int $userId, int $pathId): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM user_path_step_progress WHERE user_id = :user AND path_id = :path");
        $stmt->execute(['user' => $userId, 'path' => $pathId]);
        return (int) $stmt->fetchColumn();
    }

    private function stepBelongsToPath(int $stepId, int $pathId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM path_steps WHERE id = :step AND path_id = :path");
        $stmt->execute(['step' => $stepId, 'path' => $pathId]);
        return (bool) $stmt->fetchColumn();
    }
}
