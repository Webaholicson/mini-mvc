<?php
namespace Webaholicson\Minimvc\Core;

class Object
{  
    protected $_data;

    public function __construct($data = array())
    {
        $this->_data = $data;
    }

    public function get($key = null)
    {
        if (is_null($key)) {
            return $this->_data;
        }

        return isset($this->_data[$key]) ? $this->_data[$key] : '';
    }

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
