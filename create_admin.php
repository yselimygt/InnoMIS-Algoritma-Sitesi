<?php
require_once 'config/config.php';
require_once 'core/Database.php';

$db = Database::getInstance()->getConnection();

$password = password_hash('admin12345', PASSWORD_DEFAULT);

// Check if user exists
$check = $db->prepare("SELECT id FROM users WHERE email = 'admin@admin.com'");
$check->execute();
if ($check->fetch()) {
    echo "Admin user already exists.";
    exit;
}

$sql = "INSERT INTO users (name, surname, email, password, student_number, role, faculty, department, class_level, residence, phone) 
        VALUES ('Admin', 'User', 'admin@admin.com', :pass, '000000000', 'admin', 'Admin Faculty', 'Admin Dept', '4', 'Campus', '5555555555')";

$stmt = $db->prepare($sql);
try {
    $stmt->execute(['pass' => $password]);
    echo "Admin user created successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
