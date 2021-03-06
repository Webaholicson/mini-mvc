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
        
        $className = $this->_getClassName($className);
        $cachedName = ltrim($className . '\Cached', '\\');
        
        if ($cache && isset($this->services[$cachedName]))
            return $this->services[$cachedName];
        
        $reflectionClass = new \ReflectionClass($className);
        $constructor = $reflectionClass->getConstructor();
        
        if ($constructor && $constructor->getParameters()) {
            foreach ($constructor->getParameters() as $parameter) {
                if ($this->_canPrepareParam($parameter, $args)) {
                    $this->_prepareParam($parameter, $args);
                }
            }
        }
        
        if ($args)
            $args = $this->_reorderArgs($constructor, $args);
        
        $instance = $reflectionClass->newInstanceArgs($args);
        
        if ($cache)
            $this->services[$cachedName] = $instance;
            
        
        return $instance;
    }
    
    /**
     * If the class is not registered then it will be instantiated by the autoloader,
     * otherwise it will be looked up in the services registry
     * 
     * @param string $className
     * @return strign
     */
    protected function _getClassName($className)
    {
        if (isset($this->services[$className])) {
            return $this->services[$className];
        }
        
        return $className;
    }
    
    /**
     * Check to see if the paramater needs to be prepared before it's passed to the constructor
     * 
     * @param \ReflectionParameter $parameter
     * @param array $args
     * @return boolean
     */
    protected function _canPrepareParam(\ReflectionParameter $parameter, $args)
    {
        return !array_key_exists($parameter->getName(), $args) || 
            !is_object($args[$parameter->getName()]);
    }
    
    /**
     * Prepare the paramater to be passed to the constructor
     * 
     * @param \ReflectionParameter $parameter
     * @param array $args
     * @return void
     */
    protected function _prepareParam(\ReflectionParameter $parameter, &$args)
    {
        if ($parameter->isOptional()) {
            $args[$parameter->getName()] = $parameter->getDefaultValue();
            return;
        }

        $className = ltrim($parameter->getClass()->name, '\\');

        if (isset($args[$parameter->getName()])) {
            $className = $args[$parameter->getName()];
        }

        $args[$parameter->getName()] = $this->getObject($className, [], true);
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
