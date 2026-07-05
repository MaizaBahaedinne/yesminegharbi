<?php
$db = new mysqli('127.0.0.1', 'root', '', 'YGBD', 3307);
if ($db->connect_error) {
    echo 'CONN_ERR: ' . $db->connect_error . "\n";
    exit(1);
}
$res = $db->query("UPDATE migrations SET `group`='default' WHERE `group`=''");
if (! $res) {
    echo 'Q_ERR: ' . $db->error . "\n";
    exit(1);
}
echo 'UPDATED_ROWS=' . $db->affected_rows . "\n";
$res = $db->query('SELECT id, version, `group`, namespace, batch FROM migrations ORDER BY id');
if (! $res) {
    echo 'Q_ERR: ' . $db->error . "\n";
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . ' | ' . $row['version'] . ' | ' . $row['group'] . ' | ' . $row['namespace'] . ' | ' . $row['batch'] . "\n";
}
