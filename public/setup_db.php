<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'innomis_algo';

try {
    // Connect to MySQL server (without selecting DB)
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create Database if not exists
    echo "Creating database '$dbName' if not exists...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database created or already exists.\n";

    // Select the database
    $pdo->exec("USE `$dbName`");

    // Read SQL file
    $sqlFile = __DIR__ . '/../database.sql';
    if (!file_exists($sqlFile)) {
        die("Error: database.sql file not found at $sqlFile\n");
    }

    $sql = file_get_contents($sqlFile);

    // Execute SQL commands
    echo "Importing tables from database.sql...\n";
    $pdo->exec($sql);
    echo "Database setup completed successfully!\n";

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage() . "\n");
}
