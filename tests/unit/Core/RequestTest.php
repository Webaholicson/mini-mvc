<?php
namespace Webaholicson\Minimvc\Tests\Core;

/**
 * Tests for the HTTP request class
 * 
 * @author <webaholicson@gmail.com>
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the constructor
     * @covers Webaholicson\Minimvc\Core\Request::__construct
     * @covers Webaholicson\Minimvc\Core\Request::init
     * @covers Webaholicson\Minimvc\Core\Request::_normalizeUri
     */
    public function testIsConstructor()
    {
        $request = new \Webaholicson\Minimvc\Core\Request('http://www.example.com/test?var=1#first');
        
    }
}