<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Paths extends BaseConfig
{
    /** @var string */
    public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /** @var string */
    public string $appDirectory = __DIR__ . '/..';

    /** @var string */
    public string $writableDirectory = __DIR__ . '/../../writable';

    /** @var string */
    public string $testsDirectory = __DIR__ . '/../../tests';

    /** @var string */
    public string $viewDirectory = __DIR__ . '/../Views';
}
