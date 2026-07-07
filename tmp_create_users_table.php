<?php
$host = '127.0.0.1';
$port = 3307;
$user = 'root';
$pass = '';
$db   = 'ygbd';

$mysqli = new mysqli($host, $user, $pass, $db, $port);
if ($mysqli->connect_errno) {
    fwrite(STDERR, 'DB_ERROR:' . $mysqli->connect_error . PHP_EOL);
    exit(1);
}

$mysqli->set_charset('utf8mb4');

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(80) NULL,
    nom VARCHAR(80) NULL,
    date_naissance DATE NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NULL,
    activation_token VARCHAR(255) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
)";

if (! $mysqli->query($sql)) {
    fwrite(STDERR, 'CREATE_ERROR:' . $mysqli->error . PHP_EOL);
    exit(1);
}

$result = $mysqli->query("SHOW TABLES LIKE 'users'");
echo 'USERS_TABLE_EXISTS=' . ($result->num_rows > 0 ? '1' : '0') . PHP_EOL;
$mysqli->close();
