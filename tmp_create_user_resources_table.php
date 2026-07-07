<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'ygbd', 3307);
if ($mysqli->connect_errno) {
    fwrite(STDERR, 'DB_ERROR:' . $mysqli->connect_error . PHP_EOL);
    exit(1);
}

$mysqli->set_charset('utf8mb4');

$sql = "CREATE TABLE IF NOT EXISTS user_resources (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    resource_id INT UNSIGNED NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    KEY user_resource_idx (user_id, resource_id)
)";

if (! $mysqli->query($sql)) {
    fwrite(STDERR, 'CREATE_ERROR:' . $mysqli->error . PHP_EOL);
    exit(1);
}

echo 'USER_RESOURCES_TABLE_OK' . PHP_EOL;
$mysqli->close();
