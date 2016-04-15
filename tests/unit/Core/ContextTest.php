<?php
namespace Webaholicson\Minimvc\Tests\Core;

/**
 * Test the Context class
 * 
 * @author <webaholicson@gmail.com>
 */
class ContextTest extends \PHPUnit_Framework_TestCase
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
        
        $this->context = new \Webaholicson\Minimvc\Core\Context(
            $this->services,
            $this->request,
            $this->response,
            $this->config,
            $this->router
        );
    }
    
    /**
     * Test the getServices method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Context::getServices
     */
    public function testGetServices()
    {  
        $this->assertEquals($this->services, $this->context->getServices());
    }
    
    /**
     * Test the getRequest method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Context::getRequest
     */
    public function testGetRequest()
    {  
        $this->assertEquals($this->request, $this->context->getRequest());
    }
    
    /**
     * Test the getResponse method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Context::getResponse
     */
    public function testGetResponse()
    {
        $this->assertEquals($this->response, $this->context->getResponse());
    }
    
    /**
     * Test the getConfig method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Context::getConfig
     */
    public function testGetConfig()
    {
        $this->assertEquals($this->config, $this->context->getConfig());
    }
    
    /**
     * Test the getRouter method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Context::getRouter
     */
    public function testGetRouter()
    {
        $this->assertEquals($this->router, $this->context->getRouter());
    }
}
