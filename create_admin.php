<?php
require_once 'config/config.php';
require_once 'core/Database.php';

$db = Database::getInstance()->getConnection();

$password = password_hash('123456', PASSWORD_DEFAULT);
$email = 'admin@admin.com';

// Admins tablosu için ekle
$checkAdmin = $db->prepare("SELECT id FROM admins WHERE email = :email");
$checkAdmin->execute(['email' => $email]);
if (!$checkAdmin->fetch()) {
    $insertAdmin = $db->prepare("INSERT INTO admins (email, password) VALUES (:email, :pass)");
    $insertAdmin->execute(['email' => $email, 'pass' => $password]);
    echo "Admin (admins) tablosuna eklendi.\n";
} else {
    echo "Admin (admins) tablosunda zaten var.\n";
}

// users tablosu için geriye dönük ekle
$checkUser = $db->prepare("SELECT id FROM users WHERE email = :email");
$checkUser->execute(['email' => $email]);
if (!$checkUser->fetch()) {
    $sql = "INSERT INTO users (name, surname, email, password, student_number, role, faculty, department, class_level, residence, phone) 
            VALUES ('Admin', 'User', :email, :pass, '000000000', 'admin', 'Admin Faculty', 'Admin Dept', '4', 'Campus', '5555555555')";

    $stmt = $db->prepare($sql);
    $stmt->execute(['email' => $email, 'pass' => $password]);
    echo "Admin (users) tablosuna eklendi.\n";
} else {
    echo "Admin (users) tablosunda zaten var.\n";
}