<?php
$db = new mysqli('127.0.0.1', 'root', '', 'YGBD', 3307);
if ($db->connect_error) {
    echo 'CONN_ERR: ' . $db->connect_error . "\n";
    exit(1);
}
$res = $db->query('SHOW TABLES');
if (!$res) {
    echo 'SHOW_ERR: ' . $db->error . "\n";
    exit(1);
}
while ($row = $res->fetch_row()) {
    echo $row[0] . "\n";
}
