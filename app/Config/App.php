<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * App Configuration
 * yesminegharbi.com
 */
class App extends BaseConfig
{
    /** @var string */
    public string $baseURL = 'http://localhost/yesminegharbi/public/';

    /** @var string */
    public string $indexPage = '';

    /** @var string */
    public string $uriProtocol = 'REQUEST_URI';

    /** @var string */
    public string $defaultLocale = 'fr';

    /** @var bool */
    public bool $negotiateLocale = false;

    /** @var array<string> */
    public array $supportedLocales = ['fr'];

    /** @var string */
    public string $appTimezone = 'Africa/Tunis';

    /** @var string */
    public string $charset = 'UTF-8';

    /** @var bool */
    public bool $forceGlobalSecureRequests = false;

    /** @var array<string, string> */
    public array $proxyIPs = [];

    /**
     * Session
     */
    public string $sessionDriver           = 'CodeIgniter\Session\Handlers\FileHandler';
    public string $sessionCookieName       = 'yg_session';
    public int    $sessionExpiration       = 7200;
    public string $sessionSavePath        = '';
    public bool   $sessionMatchIP          = false;
    public int    $sessionTimeToUpdate     = 300;
    public bool   $sessionRegenerateDestroy = false;

    /**
     * Cookie
     */
    public string $cookiePrefix   = '';
    public string $cookieDomain   = '';
    public string $cookiePath     = '/';
    public bool   $cookieSecure   = false;
    public bool   $cookieHTTPOnly = false;
    public string $cookieSameSite = 'Lax';

    /**
     * CSRF
     */
    public bool   $CSRFProtection  = true;
    public string $CSRFTokenName   = 'csrf_token';
    public string $CSRFHeaderName  = 'X-CSRF-TOKEN';
    public string $CSRFCookieName  = 'csrf_cookie';
    public int    $CSRFExpire      = 7200;
    public bool   $CSRFRegenerate  = false;
    public array  $CSRFExcludeURIs = [];
    public string $CSRFSameSite    = 'Lax';

    /**
     * Reverse Proxy
     */
    public bool $reverseProxy = false;
}
