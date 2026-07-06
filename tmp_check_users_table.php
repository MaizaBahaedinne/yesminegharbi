<?php
require 'vendor/autoload.php';
$db = Config\Database::connect();
$tables = $db->listTables();
$hasUsers = in_array('users', $tables, true);
echo 'HAS_USERS=' . ($hasUsers ? '1' : '0') . PHP_EOL;
if ($hasUsers) {
    $builder = $db->table('users');
    echo 'COUNT=' . $builder->countAllResults() . PHP_EOL;
}
