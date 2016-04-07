<?php
namespace Webaholicson\Minimvc\Core;

class Config extends \Webaholicson\Minimvc\Core\Object
{
    public function __construct($data = array())
    {
        $this->init($data);
    }

    public function init($config)
    {
        $this->reset();
        $this->_data = $config;
        return $this;
    }
}
