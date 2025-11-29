<?php

class AdminModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByEmail($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM admins WHERE email = :email");
            $stmt->execute(['email' => $email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            // Eğer tablo yoksa sessizce null dön ve eski users tablosuna fallback sağlansın
            return null;
        }
    }

    public function create($email, $passwordHash) {
        $stmt = $this->db->prepare("INSERT INTO admins (email, password) VALUES (:email, :password)");
        $stmt->execute(['email' => $email, 'password' => $passwordHash]);
    }
}
