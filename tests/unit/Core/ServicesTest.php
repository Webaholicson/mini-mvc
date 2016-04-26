<?php
namespace Webaholicson\Minimvc\Tests\Core;

/**
 * Test the Context class
 * 
 * @author <webaholicson@gmail.com>
 */
class ServicesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \ReflectionProperty
     */
    private $services;

    protected function setUp()
    {  
        $this->services = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Services', 'services');
        $this->services->setAccessible(true);
    }
    
    /**
     * Test the constructor
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Services::__construct
     */
    public function testConstructor()
    {
        $mock = new \Webaholicson\Minimvc\Core\Services([
            'Webaholicson\Minimvc\Core\TestServices' => '\Webaholicson\Minimvc\Core\TestServices'
        ]);
        
        $value  = $this->services->getValue($mock);
        
        $this->assertEquals(
            $mock,
            $value['Webaholicson\Minimvc\Core\Services\Cached']
        );
        
        $this->assertContains(
            '\Webaholicson\Minimvc\Core\TestServices', 
            $value
        );
    }
    
    /**
     * Test the init method
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Services::init
     * @uses \Webaholicson\Minimvc\Core\Services::__construct
     */
    public function testInit()
    {
        $mock = new \Webaholicson\Minimvc\Core\Services();
        
        $mock->init([
            'Webaholicson\Minimvc\Core\TestServices' => '\Webaholicson\Minimvc\Core\TestServices'
        ]);
        
        $value  = $this->services->getValue($mock);
        
        $this->assertContains(
            '\Webaholicson\Minimvc\Core\TestServices', 
            $value
        );
    }
    
    /**
     * Test the getObject method
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Services::getObject
     * @covers \Webaholicson\Minimvc\Core\Services::_getClassName
     * @covers \Webaholicson\Minimvc\Core\Services::_canPrepareParam
     * @covers \Webaholicson\Minimvc\Core\Services::_prepareParam
     * @covers \Webaholicson\Minimvc\Core\Services::_reorderArgs
     * @uses \Webaholicson\Minimvc\Core\Services::__construct
     */
    public function testGetObject()
    {
        $stringClass = '\Webaholicson\Minimvc\Tests\Framework\Services\StringMock';
        $objectClass = '\Webaholicson\Minimvc\Tests\Framework\Services\ObjectMock';
        $constructorClass = '\Webaholicson\Minimvc\Tests\Framework\Services\ConstructorMock';
        
        $services = new \Webaholicson\Minimvc\Core\Services([
            ltrim($objectClass, '\\') => $objectClass,
            ltrim($constructorClass, '\\') => $constructorClass,
        ]);
        
        $object = $services->getObject(ltrim($objectClass, '\\'));
        $this->assertEquals(new $objectClass(), $object);
        
        $string = new $stringClass();
        $constructor = $services->getObject(ltrim($constructorClass, '\\'), ['string' => $stringClass]);
        $this->assertEquals(new $constructorClass($object, $string), $constructor);
    }
}
