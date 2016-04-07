<?php
namespace Webaholicson\Minimvc\Core;

/**
 * Generic object class
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class Object
{  
    /**
     *
     * @var array   Holds all the accessible data inside the object
     */
    protected $_data;

    public function __construct($data = array())
    {
        $this->_data = $data;
    }
    
    /**
     * Retrieve value associated with $key
     * 
     * @param string $key
     * @return mixed
     */
    public function get($key = null)
    {
        if (is_null($key)) {
            return $this->_data;
        }

        return isset($this->_data[$key]) ? $this->_data[$key] : '';
    }

    /**
     * Associate a key with a specific value, or if key is an array
     * extract the array into the objects data storage
     * 
     * @param string $key
     * @param mixed $value
     * @return \Webaholicson\Minimvc\Core\Object
     */
    public function set($key, $value = null)
    {
        if (is_array($key) && $key) {
            foreach($key as $k => $v) {
                $this->_data[$k] = $v;
            }
        } elseif (!empty($key) && !is_null($value) && !empty($value)) {
            $this->_data[$key] = $value;
        }

        return $this;
    }

    public function reset()
    {
        $this->_data = array();
        return $this;
    }
}
