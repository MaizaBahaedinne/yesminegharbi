<?php
$db = new mysqli('127.0.0.1', 'root', '', 'YGBD', 3307);
if ($db->connect_error) {
    echo 'CONN_ERR: ' . $db->connect_error . "\n";
    exit(1);
}
$res = $db->query("SHOW CREATE TABLE migrations");
if (!$res) {
    echo 'SHOW_ERR: ' . $db->error . "\n";
    exit(1);
}
$row = $res->fetch_assoc();
echo $row['Create Table'];
