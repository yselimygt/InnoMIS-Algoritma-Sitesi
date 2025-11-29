<?php

class ProblemModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll($onlyActive = true) {
        $sql = "SELECT * FROM problems";
        if ($onlyActive) {
            $sql .= " WHERE is_active = 1";
        }
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM problems WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM problems WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    public function getTestCases($problemId) {
        $stmt = $this->db->prepare("SELECT * FROM test_cases WHERE problem_id = :id");
        $stmt->execute(['id' => $problemId]);
        return $stmt->fetchAll();
    }

    public function deleteTestCases($problemId) {
        $stmt = $this->db->prepare("DELETE FROM test_cases WHERE problem_id = :id");
        $stmt->execute(['id' => $problemId]);
    }
    
    public function saveSubmission($userId, $problemId, $language, $code, $result, $time) {
        $sql = "INSERT INTO submissions (user_id, problem_id, language, code, result, execution_time) 
                VALUES (:uid, :pid, :lang, :code, :res, :time)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'uid' => $userId,
            'pid' => $problemId,
            'lang' => $language,
            'code' => $code,
            'res' => $result,
            'time' => $time
        ]);
    }

    public function create($data) {
        $sql = "INSERT INTO problems (title, slug, description, input_format, output_format, difficulty, tags) 
                VALUES (:title, :slug, :description, :input_format, :output_format, :difficulty, :tags)";
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function addTestCase($problemId, $data) {
        $sql = "INSERT INTO test_cases (problem_id, input, output, is_sample) 
                VALUES (:pid, :input, :output, :is_sample)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'pid' => $problemId,
            'input' => $data['input'],
            'output' => $data['output'],
            'is_sample' => isset($data['is_sample']) ? 1 : 0
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE problems SET title = :title, slug = :slug, description = :description, 
                input_format = :input_format, output_format = :output_format, difficulty = :difficulty, 
                tags = :tags, is_active = :is_active WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'input_format' => $data['input_format'],
            'output_format' => $data['output_format'],
            'difficulty' => $data['difficulty'],
            'tags' => $data['tags'],
            'is_active' => isset($data['is_active']) ? 1 : 0
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM problems WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getUserSubmissions($userId) {
        $sql = "SELECT s.*, p.title as problem_title, p.slug as problem_slug 
                FROM submissions s 
                JOIN problems p ON s.problem_id = p.id 
                WHERE s.user_id = :uid 
                ORDER BY s.created_at DESC LIMIT 20";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public function getUserSubmissionCount($userId) {
        $sql = "SELECT COUNT(*) as count FROM submissions WHERE user_id = :uid AND result = 'AC'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        $result = $stmt->fetch();
        return $result['count'];
    }
}
