<?php
namespace Webaholicson\Minimvc\Core;

class Config extends \Webaholicson\Minimvc\Core\Object
{
    /**
     * Instantiate the class and load all config options
     * 
     * @param array $config
     */
    public function __construct($config = array())
    {
        if (!$config) {
            include 'config/config.php';
        }
        
        $this->_data = $config;
    }
}
