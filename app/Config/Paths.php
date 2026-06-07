<?php

namespace Config;

/**
 * Paths
 *
 * NOTE: This class is loaded BEFORE the autoloader,
 *       so it must NOT extend BaseConfig.
 */
class Paths
{
    public string $systemDirectory   = __DIR__ . '/../../vendor/codeigniter4/framework/system';
    public string $appDirectory      = __DIR__ . '/..';
    public string $writableDirectory = __DIR__ . '/../../writable';
    public string $testsDirectory    = __DIR__ . '/../../tests';
    public string $viewDirectory     = __DIR__ . '/../Views';
}
