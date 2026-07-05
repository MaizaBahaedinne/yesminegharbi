<?php
$db = new mysqli('127.0.0.1', 'root', '', 'ygbd', 3307);
if ($db->connect_error) {
    echo 'CONNECT_ERR:' . $db->connect_error . PHP_EOL;
    exit(1);
}
$res = $db->query('SHOW COLUMNS FROM testimonials');
if (! $res) {
    echo 'Q_ERR:' . $db->error . PHP_EOL;
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . PHP_EOL;
}
