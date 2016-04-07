<?php
namespace Webaholicson\Minimvc\Core;

use \Exception;

class Services
{
    private $services;

    public function __construct($services = array())
    {
        $this->services = $services;
    }

    public function addService($key, $value)
    {
        if (isset($this->services[$key])) {
            throw new Exception(sprintf('Service "%s" is already registered.'));
        }

        $this->services[$key] = $value;
    }

    public function getService($key)
    {
        if (!isset($this->services[$key])) {
            throw new Exception(sprintf('Service "%s" not found.', $key));
        }
        
        return $this->services[$key];
    }
    
    /**
     * Instantiate or retrieve an object using dependency injection
     * 
     * @param string $className
     * @param array $args
     * @return mixed
     * @throws Exception
     */
    public function getObject($className, $args = array())
    {
        if (!isset($this->services[$className]) && !class_exists($className)) {
            throw new Exception(sprintf('Class "%s" not found.', $className));
        }
        
        $className            = isset($this->services[$className]) ? $this->services[$className] : $className;
        $reflectionClass    = new \ReflectionClass($className);
        $parameters          = $reflectionClass->getConstructor()->getParameters();
        
        foreach ($parameters as $parameter) {
            if (!array_key_exists($parameter->getName(), $args)) {
                if (!$parameter->isOptional()) {
                        $args[$parameter->getName()] = $this->getObject(
                            ltrim($parameter->getClass()->name, '\\')
                        );
                } else {
                    $args[$parameter->getName()] = $parameter->getDefaultValue();
                }
            }
        }
        
        return $reflectionClass->newInstanceArgs($args);
    }
}
