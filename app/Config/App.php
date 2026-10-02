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
    public array $supportedLocales = ['fr', 'en', 'ar'];

    public string $appTimezone = 'Africa/Tunis';

    public string $charset = 'UTF-8';

    public bool $forceGlobalSecureRequests = false;

    /** @var array<string, string> */
    public array $proxyIPs = [];

    public bool $CSPEnabled = false;

    public function __construct()
    {
        parent::__construct();

        // Behind SSL-terminating proxies, HTTPS may only be visible via forwarded headers.
        $isSecure = (! empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
            || strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https'
            || strtolower((string) ($_SERVER['HTTP_X_FORWARDED_SSL'] ?? '')) === 'on'
            || (string) ($_SERVER['SERVER_PORT'] ?? '') === '443';

        if ($isSecure) {
            $_SERVER['HTTPS'] = 'on';
            $this->baseURL = preg_replace('#^http://#i', 'https://', $this->baseURL);
        }
    }
}
