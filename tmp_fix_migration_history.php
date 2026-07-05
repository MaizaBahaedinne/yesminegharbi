<?php
$db = new mysqli('127.0.0.1', 'root', '', 'ygbd', 3307);
if ($db->connect_error) {
    echo 'CONNECT_ERR:' . $db->connect_error . PHP_EOL;
    exit(1);
}
$res = $db->query("UPDATE migrations SET class = 'CreateFormationsTable', namespace = 'App\\Database\\Migrations' WHERE version = '2026-06-07-000001'");
if (! $res) {
    echo 'UPDATE_ERR:' . $db->error . PHP_EOL;
    exit(1);
}
echo 'UPDATED_ROWS=' . $db->affected_rows . PHP_EOL;
$res = $db->query("UPDATE migrations SET namespace = 'App\\Database\\Migrations' WHERE version = '2026-06-07-000001' AND class = 'CreateFormationsTable'");
if (! $res) {
    echo 'NS_ERR:' . $db->error . PHP_EOL;
    exit(1);
}
echo 'UPDATED_NS=' . $db->affected_rows . PHP_EOL;
$res = $db->query("DELETE m1 FROM migrations m1 JOIN migrations m2 ON m1.version = m2.version AND m1.class = m2.class AND m1.group = m2.group AND m1.namespace = m2.namespace AND m1.id > m2.id");
if (! $res) {
    echo 'DUP_ERR:' . $db->error . PHP_EOL;
    exit(1);
}
echo 'DELETED_DUPES=' . $db->affected_rows . PHP_EOL;
$res = $db->query("SELECT id, version, class, `group`, namespace, batch FROM migrations ORDER BY id");
if (! $res) {
    echo 'SELECT_ERR:' . $db->error . PHP_EOL;
    exit(1);
}
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . ' | ' . $row['version'] . ' | ' . $row['class'] . ' | ' . $row['group'] . ' | ' . $row['namespace'] . ' | ' . $row['batch'] . PHP_EOL;
}
