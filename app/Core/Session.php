<?php
namespace Webaholicson\Minimvc\Core;

/**
 * Session management wrapper class
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class Session extends Object 
{
    /**
     * @var string  Session namespace
     */
    private $namespace = 'core';
    
    /**
     * @var array|Object  Session configuration
     */
    private $config;
    
    /**
     * 
     * @param array|\Webaholicson\Minimvc\Core\Object $config
     * @param array $data
     */
    public function __construct($config, $data = array())
    {
        if (is_array($config)) {
            $config = new Object($config);
        }
        
        $this->config = $config;
        parent::__construct($data);
    }
    
    /**
     * Initialize the session
     */
    public function init()
    {
        session_name($this->config->get('session_name'));
        session_set_cookie_params(
            $this->config->get('lifetime'), 
            $this->config->get('path'), 
            $this->config->get('domain'), 
            $this->config->get('secure'), 
            $this->config->get('http_only')
        );
        session_start();
    }

    /**
     * Clear the session data
     */
    public function clear()
    {
        $this->reset();
    }
    
    /**
     * Reset the session
     */
    public function reset()
    {
        parent::reset();
        session_reset();
    }
    
    /**
     * Validate the session to prevent it from being hijacked
     */
    public function validate()
    {
        
    }
    
    /**
     * Destroy the session
     */
    public function destroy()
    {
        session_destroy();
    }
}