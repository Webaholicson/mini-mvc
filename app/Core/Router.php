<?php
namespace Webaholicson\Minimvc\Core;

use \Exception;

class Router
{
    private $context;
    
    protected $_routes;
    
    public function __construct($routes = array()) 
    {
        $this->_routes = $routes;
    }
    
    public function init(\Webaholicson\Minimvc\Core\Context\ContextInterface $context, $routes)
    {
        $this->context = $context;
        $this->_routes = $routes;
        return $this;
    }

    public function match(\Webaholicson\Minimvc\Core\Request $request)
    {
        if (!$this->context) {
            throw new Exception('No context assigned to router.');
        }
        
        if (!$this->_routes) {
            throw new Exception('Router has no routes.');
        }

        foreach ($this->_routes as $uri => $route) {
            if ($request->getUri() == $uri) {
                return $this->dispatch($route);
            }
        }

      return $this->dispatch($this->_routes['no_route']);
    }

    private function dispatch($route)
    {
        $controller = $this->context->getServices()->getObject($route['controller'], [
            'context' => $this->context
        ]);
        
        $controller->dispatch($route);
    }
}
