<?php
$db = new mysqli('127.0.0.1', 'root', '', 'ygbd', 3307);
if ($db->connect_error) {
    echo 'CONNECT_ERR:' . $db->connect_error . "\n";
    exit(1);
}
$res = $db->query("SELECT version, class, `group`, namespace, batch FROM migrations ORDER BY id");
if (! $res) {
    echo 'Q_ERR:' . $db->error . "\n";
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo $row['version'] . ' | ' . $row['class'] . ' | ' . $row['group'] . ' | ' . $row['namespace'] . ' | ' . $row['batch'] . "\n";
}
