<?php
namespace Webaholicson\Minimvc\Tests\Core;

/**
 * Test the generic object class
 * 
 * @author <webaholicson@gmail.com>
 */
class ObjectTest extends \PHPUnit_Framework_TestCase
{
    private $data;
    
    protected function setUp()
    {  
        $this->data = [];
    }
    
    /**
     * Test the constructor
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Object::__construct
     */
    public function testConstruct()
    {
        $object = new \Webaholicson\Minimvc\Core\Object();
        $class = new \ReflectionClass('\Webaholicson\Minimvc\Core\Object');
        $data = $class->getProperty('_data');
        $data->setAccessible(true);
        $this->assertEquals($this->data, $data->getValue($object));
    }
    
    /**
     * Test the reset method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Object::get
     * @uses \Webaholicson\Minimvc\Core\Object::__construct
     */
    public function testGet()
    {
        $object = new \Webaholicson\Minimvc\Core\Object(['test' => true]);
        
        $this->assertTrue($object->get('test'));
        $this->assertEquals('', $object->get('empty'));
        $this->assertArrayHasKey('test', $object->get());
    }
    
    /**
     * Test the reset method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Object::reset
     * @uses \Webaholicson\Minimvc\Core\Object::__construct
     */
    public function testReset()
    {
        $object = new \Webaholicson\Minimvc\Core\Object(['test' => true]);
        $class = new \ReflectionClass('\Webaholicson\Minimvc\Core\Object');
        $data = $class->getProperty('_data');
        $data->setAccessible(true);
        
        $this->assertNotEquals($this->data, $data->getValue($object));
        $this->assertSame($object, $object->reset());
        $this->assertEquals($this->data, $data->getValue($object));
    }
    
    /**
     * Test the set method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Object::set
     * @uses \Webaholicson\Minimvc\Core\Object::__construct
     * @uses \Webaholicson\Minimvc\Core\Object::get
     */
    public function testSet()
    {
        $object = new \Webaholicson\Minimvc\Core\Object(['test' => true]);
        $this->assertTrue($object->get('test'));
        $this->assertSame($object, $object->set('test', false));
        $this->assertFalse($object->get('test'));
        $object->set(['node' => ['test' => false]]);
        $this->assertContains(false , $object->get('node'));
    }
}
