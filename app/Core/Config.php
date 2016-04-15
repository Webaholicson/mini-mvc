<?php
namespace Webaholicson\Minimvc\Core;

class Config extends \Webaholicson\Minimvc\Core\Object
{
    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->init($config);
    }
    
    /**
     * Initialize the config
     * 
     * @param array $config
     * @return \Webaholicson\Minimvc\Core\Config
     */
    public function init($config = [])
    {
        return $this->set($config);
    }
    
    /**
     * Associate a key with a specific value, or if key is an array
     * extract the array into the objects data storage
     * 
     * @param string $key
     * @param mixed $value
     * @param boolean $transformValue
     * @return \Webaholicson\Minimvc\Core\Object
     */
    public function set($key, $value = null, $transformValue = true)
    {
        if (is_array($key) && $key) {
            foreach($key as $k => $v) {
                $this->_data[$k] = $this->_transformValue($v, $transformValue);
            }
        } elseif (!empty($key) && !is_null($value)) {
            $this->_data[$key] = $this->_transformValue($value, $transformValue);
        }

        return $this;
    }
    
    /**
     * If value is an array make it an object otherwise leave it
     * 
     * @param mixed $value
     * @param boolean $transformValue
     * @return mixed
     */
    protected function _transformValue($value, $transformValue = true)
    {
        if (is_array($value) && $transformValue) {
            $value = new self($value); 
        }
        
        return $value;
    }
}
