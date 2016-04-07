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
    
    public function __construct(\Webaholicson\Minimvc\Core\Services $services, $routes = array()) 
    {
        $this->_services = $services;
        
        if (!$routes) {
            include 'config/routes.php';
        }
        
        $this->_routes = $routes;
    }
    
    /**
     * Match the request to a controller
     * 
     * @param \Webaholicson\Minimvc\Core\Request $request
     * @return type
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

      return $this->dispatch($this->_routes['no_route']);
    }
    
    /**
     * Dispatch the controller
     * 
     * @param type $route
     */
    private function dispatch($route)
    {
        $controller = $this->_services->getObject($route['controller']);
        $controller->dispatch($route);
    }
}
