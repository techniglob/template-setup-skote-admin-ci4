<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use  App\Modules\Breadcrumbs\Breadcrumbs;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];


    protected $breadcrumbs;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->breadcrumbs = new Breadcrumbs();
        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }


    /**
     * Common method to generate breadcrumbs
     * @param array $customCrumbs Optional custom crumbs [ ['title' => 'Name', 'url' => '/path'], ... ]
     * @param bool $autoGenerate Whether to auto-generate crumbs based on URL segments
     * @return string Rendered breadcrumb HTML
     */
    protected function generateBreadcrumbs(array $customCrumbs = [], bool $autoGenerate = true): string
    {
        // Always add Home breadcrumb
        $this->breadcrumbs->add('Home', '/admin');

        if ($autoGenerate) {
            // Auto-generate breadcrumbs based on URL segments
            $uri = service('uri');
            $segments = $uri->getSegments();
            $path = '/admin';

            foreach ($segments as $index => $segment) {
                if ($segment === 'admin') {
                    continue;
                }
                $path .= '/' . $segment;
                $title = ucwords(str_replace('-', ' ', $segment));
                $this->breadcrumbs->add($title, $path);
            }
        }

        // Add custom breadcrumbs if provided
        foreach ($customCrumbs as $crumb) {
            if (isset($crumb['title'], $crumb['url'])) {
                $this->breadcrumbs->add($crumb['title'], $crumb['url']);
            }
        }

        return $this->breadcrumbs->render();
    }
}
