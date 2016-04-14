<?php
namespace Webaholicson\Minimvc\Tests\Core;

/**
 * Test the App class
 * 
 * @author <webaholicson@gmail.com>
 */
class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Webaholicson\Minimvc\Core\Services
     */
    private $services;
    
    /**
     * @var \Webaholicson\Minimvc\Core\App
     */
    private $app;
    
    /**
     * @var \Webaholicson\Minimvc\Core\ContextInterface
     */
    private $context;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Bootstrap
     */
    private  $bootstrap;

    protected function setUp()
    {
        $this->context = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Context')
            ->setMethods(['getRequest', 'getResponse', 'getConfig', 'getRouter', 'getServices'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->services = $this->getMockBuilder('\Webaholicson\Minimvc\Core\Services')
            ->setMethods(['getObject'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->app = $this->getMockBuilder('\Webaholicson\Minimvc\Core\App')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->bootstrap = new \Webaholicson\Minimvc\Core\Bootstrap($this->services);
    }
    
    /**
     * Test the construct method
     * @covers \Webaholicson\Minimvc\Core\Bootstrap::__construct
     */
    public function testConstructor()
    {
        $class = new \ReflectionClass($this->bootstrap);
        $services = $class->getProperty('services');
        $services->setAccessible(true);
        $this->assertEquals($this->services, $services->getValue($this->bootstrap));
    }
    
    /**
     * Test bootstraping the class with init method
     * 
     * @cover \Webaholicson\Minimvc\Core\Bootstrap::init
     * @cover \Webaholicson\Minimvc\Core\Bootstrap::autoload
     * @cover \Webaholicson\Minimvc\Core\Bootstrap::initContext
     */
    public function testInit()
    {
        $this->services->expects($this->exactly(2))
            ->method('getObject')
            ->withConsecutive(
                [
                    $this->equalTo('Webaholicson\Minimvc\Core\ContextInterface'),
                    $this->equalTo(['services' => $this->services]),
                    $this->equalTo(true)
                ],
                [
                    $this->equalTo('Webaholicson\Minimvc\Core\App'),
                    $this->equalTo(['context' => $this->context]),
                    $this->equalTo(true)
                ]
            )->will($this->onConsecutiveCalls(
                $this->context,
                $this->app
            ));
        
        $this->bootstrap->autoload('\Webaholicson\Minimvc\Core\App');
        $this->assertInstanceOf(\Webaholicson\Minimvc\Core\App::class, $this->bootstrap->init());
    }
}