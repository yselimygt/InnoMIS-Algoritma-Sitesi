<?php

class LearningPathModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM learning_paths");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM learning_paths WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getSteps($pathId)
    {
        $sql = "SELECT ps.*, p.title, p.slug, p.difficulty, p.description AS problem_description 
                FROM path_steps ps 
                JOIN problems p ON ps.problem_id = p.id 
                WHERE ps.path_id = :pid 
                ORDER BY ps.order_index ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['pid' => $pathId]);
        return $stmt->fetchAll();
    }
}
