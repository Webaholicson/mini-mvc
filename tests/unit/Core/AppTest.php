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
            ->setMethods(['route'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->services = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Services')
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
     * Test running the app
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\App::getResponse
     */
    public function testRun()
    {
        $this->app = new \Webaholicson\Minimvc\Core\App($this->context);
    }
}
