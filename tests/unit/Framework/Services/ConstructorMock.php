<?php
namespace Webaholicson\Minimvc\Tests\Framework\Services;

/**
 * Class used for testing the services object creation
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class ConstructorMock
{
    /**
     * @var \Webaholicson\Minimvc\Tests\Framework\Services\ObjectMock
     */
    private $object;
    
    /**
     * @var \Webaholicson\Minimvc\Tests\Framework\Services\StringMock
     */
    private $string;
    
    /**
     * Class constructor
     * 
     * @param \Webaholicson\Minimvc\Tests\Framework\Services\ObjectMock
     * @param \Webaholicson\Minimvc\Tests\Framework\Services\StringMock
     * @param boolean $optional
     */
    public function __construct(
        \Webaholicson\Minimvc\Tests\Framework\Services\ObjectMock $object,
        \Webaholicson\Minimvc\Tests\Framework\Services\StringMock $string,
        $optional = true
    ) {
        $this->object = $object;
        $this->string = $string;
    }
}

