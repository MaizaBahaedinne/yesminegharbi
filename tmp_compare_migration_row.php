<?php
$db = new mysqli('127.0.0.1', 'root', '', 'ygbd', 3307);
if ($db->connect_error) {
    echo 'CONNECT_ERR:' . $db->connect_error . PHP_EOL;
    exit(1);
}
$res = $db->query("SELECT version, class, namespace FROM migrations WHERE version='2026-06-07-000001'");
if (! $res) {
    echo 'Q_ERR:' . $db->error . PHP_EOL;
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo $row['version'] . ' | ' . $row['class'] . ' | ' . $row['namespace'] . PHP_EOL;
}
