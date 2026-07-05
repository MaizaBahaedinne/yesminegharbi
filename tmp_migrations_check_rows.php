<?php
$db = new mysqli('127.0.0.1', 'root', '', 'YGBD', 3307);
if ($db->connect_error) {
    echo 'CONN_ERR: ' . $db->connect_error . "\n";
    exit(1);
}
$res = $db->query('SELECT version, `group`, namespace, batch, COUNT(*) AS cnt FROM migrations GROUP BY version, `group`, namespace, batch ORDER BY version');
if (!$res) {
    echo 'Q_ERR: ' . $db->error . "\n";
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo sprintf("%s | %s | %s | %s | %s\n", $row['version'], $row['group'], $row['namespace'], $row['batch'], $row['cnt']);
}
echo "---\n";
$res = $db->query('SELECT id, version, `group`, namespace, batch FROM migrations ORDER BY id');
if (!$res) {
    echo 'Q_ERR: ' . $db->error . "\n";
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo sprintf("%s | %s | %s | %s | %s\n", $row['id'], $row['version'], $row['group'], $row['namespace'], $row['batch']);
}
