<?php
namespace Webaholicson\Minimvc\Tests\Core;

/**
 * Test the Config class
 * 
 * @author <webaholicson@gmail.com>
 */
class ConfigtTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test setting array values without transforming and non-array values.
     * Also test constructor and init method
     * 
     * @group unit
     * @covers \Webaholicson\Minimvc\Core\Config::init
     * @covers \Webaholicson\Minimvc\Core\Config::set
     * @covers \Webaholicson\Minimvc\Core\Config::_transformValue
     * @covers \Webaholicson\Minimvc\Core\Config::__construct
     * @uses \Webaholicson\Minimvc\Core\Object::get Get value from config
     * @uses \Webaholicson\Minimvc\Core\Object::__construct Calls parent constructor
     */
    public function testSettingKeyValue()
    {
        $config  = new \Webaholicson\Minimvc\Core\Config();
        $returnValue = $config->init([
            'test' => true,
            'node' => array(
                'test' => false
            )
        ]);
        
        $config->set('one_plus_one', 2);
        $config->set('operations', ['add', 'subtract'], false);
        
        $this->assertTrue($config->get('test'));
        $this->assertFalse($config->get('node')->get('test'));
        $this->assertSame($returnValue, $config);
        $this->assertEquals(2, $config->get('one_plus_one'));
        $this->assertContains('add', $config->get('operations'));
    }
}
