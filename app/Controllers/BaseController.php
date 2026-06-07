<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController — common setup for all controllers
 */
abstract class BaseController extends Controller
{
    /** @var IncomingRequest|CLIRequest */
    protected $request;

    /** @var array<string, mixed> */
    protected $helpers = ['url', 'form', 'html', 'text'];

    /** @var array<string, mixed> Data shared with every view */
    protected array $viewData = [];

    public function initController(
        RequestInterface  $request,
        ResponseInterface $response,
        LoggerInterface   $logger
    ): void {
        parent::initController($request, $response, $logger);

        // Global view data available in all views
        $this->viewData = [
            'currentUri' => service('uri'),
            'isLoggedIn' => session()->has('user_id'),
            'user'       => session()->get('user'),
        ];
    }

    /**
     * Render a view with the main layout
     */
    protected function render(string $view, array $data = [], int $statusCode = 200): string
    {
        $data = array_merge($this->viewData, $data);
        $data['content'] = view($view, $data);
        return view('layouts/main', $data);
    }
}
