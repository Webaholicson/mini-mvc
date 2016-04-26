<?php
namespace Webaholicson\Minimvc\Core;

/**
 * Class used to route all request to the reight controller
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class Router
{
    /**
     * @var \Webaholicson\Minimvc\Core\Services 
     */
    protected $_services;
    
    /**
     * @var array   Array used to store all declared routes 
     */
    protected $_routes;
    
    public function __construct(\Webaholicson\Minimvc\Core\Services $services, $routes = [])
    {
        $this->_services = $services;
        $this->init($routes);
    }
    
    /**
     * Initialize the routes
     * 
     * @param array $routes
     */
    public function init($routes = [])
    {
        $this->_routes = $routes;
    }
    
    /**
     * Match the request to a controller
     * 
     * @param \Webaholicson\Minimvc\Core\Request $request
     * @throws \Exception
     */
    public function match(\Webaholicson\Minimvc\Core\Request $request)
    {
        if (!$this->_services) {
            throw new \Exception('No service provider assigned to router.');
        }
        
        if (!$this->_routes) {
            throw new \Exception('Router has no routes.');
        }

        foreach ($this->_routes as $uri => $route) {
            if ($request->getUri() == $uri) {
                return $this->dispatch($route);
            }
        }

      $this->dispatch($this->_routes['no_route']);
    }
    
    /**
     * Dispatch the controller
     * 
     * @param mixed $route
     */
    public function dispatch($route)
    {
        try {
            $controllerName = $route['controller'];
            $params = array_slice($route, 1);
            $controller = $this->_services->getObject($controllerName, $params);
            $controller->dispatch($route);
        } catch (\Exception $e) {
            $this->dispatch($this->_routes['no_route']);
        }
    }
}
