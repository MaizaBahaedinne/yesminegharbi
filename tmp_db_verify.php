<?php
$db = new mysqli('127.0.0.1', 'root', '', 'ygbd', 3307);
if ($db->connect_error) {
    echo 'CONNECT_ERR: ' . $db->connect_error . "\n";
    exit(1);
}
$res = $db->query('SELECT DATABASE()');
$row = $res ? $res->fetch_row() : [null];
echo 'DATABASE=' . $row[0] . "\n";
$res = $db->query('SELECT USER()');
$row = $res ? $res->fetch_row() : [null];
echo 'USER=' . $row[0] . "\n";
$res = $db->query('SHOW TABLES LIKE "migrations"');
echo 'MIGRATIONS_TABLE=' . ($res && $res->num_rows ? 'YES' : 'NO') . "\n";
$res = $db->query('SELECT COUNT(*) AS cnt FROM migrations');
if ($res) { $row = $res->fetch_assoc(); echo 'MIGRATION_COUNT=' . $row['cnt'] . "\n"; }
$res = $db->query('SHOW DATABASES LIKE "ygbd"');
echo 'DB_ygbd=' . ($res && $res->num_rows ? 'YES' : 'NO') . "\n";
$res = $db->query('SHOW DATABASES LIKE "YGBD"');
echo 'DB_YGBD=' . ($res && $res->num_rows ? 'YES' : 'NO') . "\n";
$res = $db->query('SHOW VARIABLES LIKE "lower_case_table_names"');
if ($res) { $row = $res->fetch_assoc(); echo 'LOWER_CASE_TABLE_NAMES=' . $row['Value'] . "\n"; }
$res = $db->query('SELECT id, version, `group`, namespace, batch FROM migrations ORDER BY id LIMIT 20');
if ($res) {
    while ($row = $res->fetch_assoc()) {
        echo sprintf("ROW=%s|%s|%s|%s|%s\n", $row['id'], $row['version'], $row['group'], $row['namespace'], $row['batch']);
    }
}
