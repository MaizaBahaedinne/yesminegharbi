<?php
$db = new mysqli('127.0.0.1', 'root', '', 'YGBD', 3307);
if ($db->connect_error) {
    echo 'CONN_ERR: ' . $db->connect_error . "\n";
    exit(1);
}
$migrations = [
    ['version' => '2026-06-07-000001', 'class' => 'CreateFormationsTable'],
    ['version' => '2026-06-07-000002', 'class' => 'CreateModulesTable'],
    ['version' => '2026-06-07-000003', 'class' => 'CreateRessourcesTable'],
    ['version' => '2026-06-07-000004', 'class' => 'CreateNewsletterAndContactTables'],
    ['version' => '2026-06-07-000005', 'class' => 'CreateSettingsTable'],
    ['version' => '2026-07-05-000001', 'class' => 'CreateTestimonialsTable'],
];
$time = time();
$batch = 1;
$stmt = $db->prepare('INSERT IGNORE INTO migrations (`version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES (?, ?, ?, ?, ?, ?)');
if (! $stmt) {
    echo 'PREP_ERR: ' . $db->error . "\n";
    exit(1);
}
$group = '';
$namespace = 'App\\Database\\Migrations';
foreach ($migrations as $migration) {
    $stmt->bind_param('ssssii', $migration['version'], $migration['class'], $group, $namespace, $time, $batch);
    if (! $stmt->execute()) {
        echo 'EXEC_ERR: ' . $stmt->error . "\n";
        exit(1);
    }
    echo 'Inserted/migrated: ' . $migration['version'] . "\n";
}
$stmt->close();
$res = $db->query('SELECT id, version, class, `group`, namespace, batch FROM migrations ORDER BY id');
if ($res) {
    while ($row = $res->fetch_assoc()) {
        echo sprintf("%s | %s | %s | %s | %s | %s\n", $row['id'], $row['version'], $row['class'], $row['group'], $row['namespace'], $row['batch']);
    }
}
