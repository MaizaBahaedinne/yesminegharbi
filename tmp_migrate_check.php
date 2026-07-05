<?php
$db = new mysqli('127.0.0.1', 'root', '', 'YGBD', 3307);
if ($db->connect_error) {
    echo 'CONN_ERR: ' . $db->connect_error . "\n";
    exit(1);
}
$res = $db->query("SHOW TABLES LIKE 'migrations'");
if (!$res) {
    echo 'SHOW_ERR: ' . $db->error . "\n";
    exit(1);
}
if ($res->num_rows === 0) {
    echo "NO_MIGRATIONS_TABLE\n";
    exit(0);
}
$res = $db->query('SELECT * FROM migrations ORDER BY id');
if (!$res) {
    echo 'Q_ERR: ' . $db->error . "\n";
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . ' | ' . $row['version'] . ' | ' . $row['group'] . ' | ' . $row['batch'] . "\n";
}
