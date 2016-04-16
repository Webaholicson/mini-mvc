<?php
namespace Webaholicson\Minimvc\Tests\Core;

/**
 * Test the generic object class
 * 
 * @author <webaholicson@gmail.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Webaholicson\Minimvc\Core\Services 
     */
    private $services;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Request
     */
    private $request;
    
    protected function setUp()
    {  
        $this->services = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Services')
            ->setMethods(['getObject'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->request = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Request')
            ->setMethods(['getUri'])
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    /**
     * Test the constructor
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Router::__construct
     * @covers \Webaholicson\Minimvc\Core\Router::init
     */
    public function testConstruct()
    {
        $object = new \Webaholicson\Minimvc\Core\Router($this->services, ['test' => true]);
        $class = new \ReflectionClass('\Webaholicson\Minimvc\Core\Router');
        $services = $class->getProperty('_services');
        $routes = $class->getProperty('_routes');
        $services->setAccessible(true);
        $routes->setAccessible(true);
        $this->assertEquals($this->services, $services->getValue($object));
        $this->assertEquals(['test' => true], $routes->getValue($object));
    }
    
    /**
     * Test the match method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Router::match
     */
    public function testMatch()
    {
        $fixed_routes = ['/' => ['controller' => '\Webaholicson\Minimvc\Page\Controller\Index']];
        
        $this->request->expects($this->atLeastOnce())
            ->method('getUri')
            ->willReturn('/');
        
        $router = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Router')
            ->setMethods(['dispatch'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $router->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo($fixed_routes['/']));
        
        $class = new \ReflectionClass('\Webaholicson\Minimvc\Core\Router');
        $routes = $class->getProperty('_routes');
        $routes->setAccessible(true);
        $routes->setValue($router, $fixed_routes);
        
        $services = $class->getProperty('_services');
        $services->setAccessible(true);
        $services->setValue($router, $this->services);
        
        $router->match($this->request);
    }
    
    /**
     * Test the match method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Router::match
     */
    public function testMatchNoRoute()
    {
        $fixed_routes = ['no_route' => ['controller' => '\Webaholicson\Minimvc\Page\Controller\NoRoute']];
        
        $this->request->expects($this->atLeastOnce())
            ->method('getUri')
            ->willReturn('/testo');
        
        $router = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Router')
            ->setMethods(['dispatch'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $router->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo($fixed_routes['no_route']));
        
        $class = new \ReflectionClass('\Webaholicson\Minimvc\Core\Router');
        $routes = $class->getProperty('_routes');
        $routes->setAccessible(true);
        $routes->setValue($router, $fixed_routes);
        
        $services = $class->getProperty('_services');
        $services->setAccessible(true);
        $services->setValue($router, $this->services);
        
        $router->match($this->request);
    }
    
    /**
     * Test the match method with no services provider
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Router::match
     */
    public function testMatchNoServices()
    {
        $router = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Router')
            ->setMethods(['dispatch'])
            ->disableOriginalConstructor()
            ->getMock();
        
        try {
            $router->match($this->request);  
        } catch (\Exception $e) {
            $this->assertEquals('No service provider assigned to router.', $e->getMessage());
        }
    }
    
    /**
     * Test the match method with no routes
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Router::match
     */
    public function testMatchNoRoutes()
    {
        $router = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Router')
            ->setMethods(['dispatch'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $class = new \ReflectionClass('\Webaholicson\Minimvc\Core\Router');
        $services = $class->getProperty('_services');
        $services->setAccessible(true);
        $services->setValue($router, $this->services);
        
        try {
            $router->match($this->request);  
        } catch (\Exception $e) {
            $this->assertEquals('Router has no routes.', $e->getMessage());
        }
    }
    
    /**
     * Test the dispatch method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Router::dispatch
     * @uses \Webaholicson\Minimvc\Core\Router::init
     * @uses \Webaholicson\Minimvc\Core\Router::__construct
     */
    public function testDispatch()
    {
        $route = ['controller' => '\Webaholicson\Minimvc\Page\Controller\Index'];
        
        $controller = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Controller\Index')
            ->setMethods(['dispatch'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $controller->expects($this->once())
            ->method('dispatch');
        
        $router = new \Webaholicson\Minimvc\Core\Router($this->services, [$route]);
        
        $this->services->expects($this->once())
            ->method('getObject')
            ->with($this->equalTo($route['controller']))
            ->willReturn($controller);
        
        $router->dispatch($route);
    }
    
    /**
     * Test the dispatch method with invalid route
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Router::dispatch
     * @uses \Webaholicson\Minimvc\Core\Router::init
     * @uses \Webaholicson\Minimvc\Core\Router::__construct
     */
    public function testDispatchInvalidRoute()
    {
        $routes = [
            'no_route' => ['controller' => '\Webaholicson\Minimvc\Page\Controller\NoRoute']
        ];
        
        $controller = $this->getMockBuilder($routes['no_route']['controller'])
            ->setMethods(['dispatch'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $controller->expects($this->once())
            ->method('dispatch');
        
        $router = new \Webaholicson\Minimvc\Core\Router($this->services, $routes);
        
        $this->services->expects($this->exactly(2))
            ->method('getObject')
            ->withConsecutive(
                [$this->equalTo('\Webaholicson\Minimvc\Page\Controller\Test')],
                [$this->equalTo($routes['no_route']['controller'])]
            )->will($this->onConsecutiveCalls(
                $this->throwException(new \Exception('Class not found.')),
                $this->returnValue($controller)
            ));
        
        $router->dispatch(['controller' => '\Webaholicson\Minimvc\Page\Controller\Test']);
    }
}
