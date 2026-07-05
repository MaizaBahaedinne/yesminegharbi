<?php
require 'system/bootstrap.php';
require 'vendor/autoload.php';
$config = config('Config\\Database');
$db = db_connect();
echo 'DATABASE=' . $db->database . PHP_EOL;
echo 'HOST=' . $db->hostname . ':' . $db->port . PHP_EOL;
echo 'USER=' . $db->username . PHP_EOL;
echo 'PASS=' . ($db->password === '' ? 'empty' : 'set') . PHP_EOL;
