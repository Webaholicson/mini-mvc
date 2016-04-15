<?php
namespace Webaholicson\Minimvc\Tests\Core;

/**
 * Test the App class
 * 
 * @author <webaholicson@gmail.com>
 */
class AppTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Webaholicson\Minimvc\Core\App
     */
    private $app;
    
    /**
     * @var \Webaholicson\Minimvc\Core\ContextInterface
     */
    private $context;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Request
     */
    private $request;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Response
     */
    private  $response;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Config
     */
    private $config;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Services
     */
    private $services;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Router
     */
    private $router;

    protected function setUp()
    {
        $this->context = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Context')
            ->setMethods(['getRequest', 'getResponse', 'getConfig', 'getRouter', 'getServices'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->request = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Request')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->response = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Response')
            ->setMethods(['send'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->router = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Router')
            ->setMethods(['match'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->services = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Services')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->config = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Config')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    /**
     * Test the construct
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\App::__construct
     */
    public function testConstruct()
    {
        $this->context->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->request);
        
        $this->context->expects($this->once())
            ->method('getResponse')
            ->willReturn($this->response);
        
        $this->context->expects($this->once())
            ->method('getRouter')
            ->willReturn($this->router);
        
        $this->context->expects($this->once())
            ->method('getConfig')
            ->willReturn($this->config);
        
        $this->context->expects($this->once())
            ->method('getServices')
            ->willReturn($this->services);
        
        $this->app = new \Webaholicson\Minimvc\Core\App($this->context);
    }
    
    /**
     * Test getting the request from the app
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\App::getRequest
     * @uses \Webaholicson\Minimvc\Core\App::__construct
     */
    public function testGetRequest()
    {
        $this->context->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->request);
        
        $this->app = new \Webaholicson\Minimvc\Core\App($this->context);
        
        $this->assertEquals($this->request, $this->app->getRequest());
    }
    
    /**
     * Test getting the response from the app
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\App::getResponse
     * @uses \Webaholicson\Minimvc\Core\App::__construct
     */
    public function testGetResponse()
    {
        $this->context->expects($this->once())
            ->method('getResponse')
            ->willReturn($this->response);
        
        $this->app = new \Webaholicson\Minimvc\Core\App($this->context);
        $this->assertEquals($this->response, $this->app->getResponse());
    }
    
    /**
     * Test getting the app config object
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\App::getConfig
     * @uses \Webaholicson\Minimvc\Core\App::__construct
     */
    public function testGetConfig()
    {
        $this->context->expects($this->once())
            ->method('getConfig')
            ->willReturn($this->config);
        
        $this->app = new \Webaholicson\Minimvc\Core\App($this->context);
        $this->assertEquals($this->config, $this->app->getConfig());
    }
    
    /**
     * Test getting the app services provider object
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\App::getServices
     * @uses \Webaholicson\Minimvc\Core\App::__construct
     */
    public function testGetServices()
    {
        $this->context->expects($this->once())
            ->method('getServices')
            ->willReturn($this->services);
        
        $this->app = new \Webaholicson\Minimvc\Core\App($this->context);
        $this->assertEquals($this->services, $this->app->getServices());
    }
    
    /**
     * Test getting the app router object
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\App::getRouter
     * @uses \Webaholicson\Minimvc\Core\App::__construct
     */
    public function testGetRouter()
    {
        $this->context->expects($this->once())
            ->method('getRouter')
            ->willReturn($this->router);
        
        $this->app = new \Webaholicson\Minimvc\Core\App($this->context);
        $this->assertEquals($this->router, $this->app->getRouter());
    }
    
    /**
     * Test running the app
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\App::run
     * @covers \Webaholicson\Minimvc\Core\App::isRunning
     * @uses \Webaholicson\Minimvc\Core\App::__construct
     */
    public function testRun()
    {
        $this->context->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->request);
        
        $this->context->expects($this->once())
            ->method('getResponse')
            ->willReturn($this->response);
        
        $this->context->expects($this->once())
            ->method('getRouter')
            ->willReturn($this->router);
        
        $this->router->expects($this->once())
            ->method('match')
            ->with($this->identicalTo($this->request));
        
        $this->response->expects($this->once())
            ->method('send');
        
        $this->app = new \Webaholicson\Minimvc\Core\App($this->context);
        $this->app->run();
    }
    
    /**
     * Test to see if app is already running
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\App::run
     */
    public function testIsRunning()
    {
        $this->app = $this->getMockBuilder('\Webaholicson\Minimvc\Core\App')
            ->setMethods(['isRunning'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->app->expects($this->once())
            ->method('isRunning')
            ->willReturn(true);

        ob_start();
        $this->app->run();
        $contents = ob_get_clean();
        $this->assertContains('App is already running.', $contents);
    }
}
