<?php
namespace Webaholicson\Minimvc\Core;

/**
 * This class is responsible for instantiating all objects using dependency invertion
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
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
        $this->services = $services;
        $this->services[__CLASS__ . '\Cached'] = $this;
    }
    
    /**
     * Initialize the services
     * 
     * @param array $services
     * @return \Webaholicson\Minimvc\Core\Services
     */
    public function init($services = [])
    {
        $this->services = $services;
        return $this;
    }
    
    /**
     * Instantiate or retrieve an object using dependency injection
     * 
     * @param string $className
     * @param array $args
     * @param boolean $cache
     * @return mixed
     * @throws Exception
     */
    public function getObject($className, $args = [], $cache = false)
    {
        if (!isset($this->services[$className]) && !class_exists($className))
            throw new \Exception(sprintf('Class "%s" not found.', $className));
        
        $className = isset($this->services[$className]) ? $this->services[$className] : $className;
        $cachedName = ltrim($className . '\Cached', '\\');
        
        if ($cache && isset($this->services[$cachedName]))
            return $this->services[$cachedName];
        
        $reflectionClass    = new \ReflectionClass($className);
        
        if ($reflectionClass->getConstructor()) {
            foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
                if (!array_key_exists($parameter->getName(), $args) || !is_object($args[$parameter->getName()])) {
                    if (!$parameter->isOptional()) {
                        $args[$parameter->getName()] = $this->getObject(
                            isset($args[$parameter->getName()]) ? 
                                $args[$parameter->getName()] : 
                                ltrim($parameter->getClass()->name, '\\'), [], true
                        );
                    } else {
                        $args[$parameter->getName()] = $parameter->getDefaultValue();
                    }
                }
            }
        }
        
        if ($args)
            $args = $this->_reorderArgs($reflectionClass->getConstructor(), $args);
        
        $instance = $reflectionClass->newInstanceArgs($args);
        
        if ($cache)
            $this->services[$cachedName] = $instance;
        
        return $instance;
    }
    
    /**
     * Reorder the constructor arguments to be passed to the reflection constructor
     * 
     * @param \ReflectionMethod $constructor
     * @param array $args
     * @return array
     */
    protected function _reorderArgs(\ReflectionMethod $constructor, $args)
    {
        $result = [];
        
        foreach ($constructor->getParameters() as $parameter) {
            $result[$parameter->getName()] = $args[$parameter->getName()];
        }
        
        return $result;
    }
}
