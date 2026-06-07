<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    /** @var string */
    public string $defaultGroup = 'default';

    /** @var array */
    public array $default = [
        'DSN'          => '',
        'hostname'     => '127.0.0.1',
        'username'     => 'root',
        'password'     => '',
        'database'     => 'YGBD',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => true,
        'charset'      => 'utf8mb4',
        'DBCollat'     => 'utf8mb4_general_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3307,
        'numberNative' => false,
    ];

    /** @var array */
    public array $tests = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'YGBD_test',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => 'tests_',
        'charset'  => 'utf8mb4',
        'DBCollat' => 'utf8mb4_general_ci',
        'port'     => 3306,
    ];
}
