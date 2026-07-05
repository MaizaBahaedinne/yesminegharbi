<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    public string $baseURL = 'http://localhost/yesminegharbi/public/';

    /** @var list<string> */
    public array $allowedHostnames = [];

    public string $indexPage = '';

    public string $uriProtocol = 'REQUEST_URI';

    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    public string $defaultLocale = 'fr';

    public bool $negotiateLocale = false;

    /** @var list<string> */
    public array $supportedLocales = ['fr'];

    public string $appTimezone = 'Africa/Tunis';

    public string $charset = 'UTF-8';

    public bool $forceGlobalSecureRequests = false;

    /** @var array<string, string> */
    public array $proxyIPs = [];

    public bool $CSPEnabled = false;
}
