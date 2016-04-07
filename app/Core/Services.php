<?php
namespace Webaholicson\Minimvc\Core;

/**
 * This class is responsible for instantiating all objects using dependency invertion
 */
class Services
{
    /**
     * @var array   Stores all registered services
     */
    private $services;
    
    /**
     * Instantiate the class and load all registered services
     * 
     * @param array $services
     */
    public function __construct($services = [])
    {
        if (!$services) {
            include 'config/services.php';
        }
        
        $this->services = $services;
        $this->services[__CLASS__ . '\Cached'] = $this;
    }
    
    /**
     * Instantiate or retrieve an object using dependency injection
     * 
     * @param string $className
     * @param array $args
     * @return mixed
     * @throws Exception
     */
    public function getObject($className, $args = [], $cache = false)
    {
        if (!isset($this->services[$className]) && !class_exists($className)) {
            throw new Exception(sprintf('Class "%s" not found.', $className));
        }
        
        $className            = isset($this->services[$className]) ? $this->services[$className] : $className;
        $cachedName       = ltrim($className . '\Cached', '\\');
        
        if ($cache && isset($this->services[$cachedName])) {
            return $this->services[$cachedName];
        }
        
        $reflectionClass    = new \ReflectionClass($className);
        
        if ($reflectionClass->getConstructor()) {
            foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
                if (!array_key_exists($parameter->getName(), $args)) {
                    if (!$parameter->isOptional()) {
                            $args[$parameter->getName()] = $this->getObject(
                                ltrim($parameter->getClass()->name, '\\'), [], true
                            );
                    } else {
                        $args[$parameter->getName()] = $parameter->getDefaultValue();
                    }
                }
            }
        }
        
        $instance = $reflectionClass->newInstanceArgs($args);
        
        if ($cache) {
            $this->services[$cachedName] = $instance;
        }
        
        return $instance;
    }
}
