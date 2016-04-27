<?php
namespace Webaholicson\Minimvc\Tests\Core;

/**
 * Tests for the HTTP response class
 * 
 * @author <webaholicson@gmail.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test adding a header to the response
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::setHeader
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testSetHeader()
    {
        $headers = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_headers');
        $headers->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        $response->setHeader('Content-Type', 'application/json');
        
        $this->assertContains('application/json', $headers->getValue($response));
        $this->assertArrayHasKey('Content-Type', $headers->getValue($response));
    }
    
    /**
     * Test getting a header from the resonse object
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::getHeader
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testGetHeader()
    {
        $headers = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_headers');
        $headers->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        $headers->setValue($response, array('Content-Type' => 'application/json'));
        
        $this->assertEquals('application/json', $response->getHeader('Content-Type'));
    }
    
    /**
     * Test setting the http version to the resonse
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::setHttpVersion
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testSetHttpVersion()
    {
        $version = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_httpVersion');
        $version->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        $response->setHttpVersion('HTTP/1.0');
        
        $this->assertEquals('HTTP/1.0', $version->getValue($response));
    }
    
    /**
     * Test getting the http version from the response
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::getHttpVersion
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testGetHttpVersion()
    {
        $version = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_httpVersion');
        $version->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        $this->assertEquals('HTTP/1.1', $response->getHttpVersion());
        
        $version->setValue($response, 'HTTP/1.0');
        $this->assertEquals('HTTP/1.0', $response->getHttpVersion());
    }
    
    /**
     * Test getting the status code from the response
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::getStatusCode
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testGetStatusCode()
    {
        $code = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_statusCode');
        $code->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        $this->assertEquals('200', $response->getStatusCode());
        
        $code->setValue($response, '201');
        $this->assertEquals('201', $response->getStatusCode());
    }
    
    /**
     * Test setting the status code to the resonse
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::setStatusCode
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testSetStatusCode()
    {
        $code = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_statusCode');
        $code->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        $response->setStatusCode('201');
        
        $this->assertEquals('201', $code->getValue($response));
    }
    
    /**
     * Test getting the reason phrase from the response
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::getReasonPhrase
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testGetReasonPhrase()
    {
        $phrase = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_responsePhrase');
        $phrase->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        $this->assertEquals('OK', $response->getReasonPhrase());
        
        $phrase->setValue($response, 'FAIL');
        $this->assertEquals('FAIL', $response->getReasonPhrase());
    }
    
    /**
     * Test setting the reason phrase to the resonse
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::setReasonPhrase
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testSetReasonPhrase()
    {
        $phrase = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_responsePhrase');
        $phrase->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        $response->setReasonPhrase('TEST');
        
        $this->assertEquals('TEST', $phrase->getValue($response));
    }
    
    /**
     * Test getting the body from the response
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::getBody
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testGetBody()
    {
        $body = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_body');
        $body->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        
        $body->setValue($response, 'TEST');
        $this->assertEquals('TEST', $response->getBody());
    }
    
    /**
     * Test setting the body to the resonse
     * 
     * @group unit
     * @group core
     * @covers \Webaholicson\Minimvc\Core\Response::setBody
     * @uses \Webaholicson\Minimvc\Core\Response::__construct
     */
    public function testSetBody()
    {
        $body = new \ReflectionProperty('\Webaholicson\Minimvc\Core\Response', '_body');
        $body->setAccessible(true);
        
        $response = new \Webaholicson\Minimvc\Core\Response();
        $response->setBody('TEST');
        
        $this->assertEquals('TEST', $body->getValue($response));
    }
}