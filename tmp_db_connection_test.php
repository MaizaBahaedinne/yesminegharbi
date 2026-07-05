<?php
$tests = [
    ['user' => 'root', 'password' => '', 'label' => 'blank'],
    ['user' => 'root', 'password' => 'root', 'label' => 'root_pass'],
];
foreach ($tests as $test) {
    echo "--- {$test['label']} ---\n";
    $db = new mysqli('127.0.0.1', $test['user'], $test['password'], 'ygbd', 3307);
    if ($db->connect_error) {
        echo 'CONNECT_ERR: ' . $db->connect_error . "\n";
        continue;
    }
    $res = $db->query('SELECT COUNT(*) AS cnt FROM migrations');
    if (! $res) {
        echo 'Q_ERR: ' . $db->error . "\n";
        continue;
    }
    $row = $res->fetch_assoc();
    echo 'COUNT=' . $row['cnt'] . "\n";
    $res = $db->query('SELECT version, class, `group`, namespace, batch FROM migrations ORDER BY id');
    if (! $res) {
        echo 'Q_ERR: ' . $db->error . "\n";
        continue;
    }
    while ($row = $res->fetch_assoc()) {
        echo $row['version'] . ' | ' . $row['class'] . ' | ' . $row['group'] . ' | ' . $row['namespace'] . ' | ' . $row['batch'] . "\n";
    }
}
