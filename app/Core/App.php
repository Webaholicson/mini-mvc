<?php
namespace Webaholicson\Minimvc\Core;

class App
{
    /**
     * @var \Webaholicson\Minimvc\Core\Config App configuration object
     */
    private $config;

    /**
     * @var Webaholicson\Minimvc\Core\Services App services provider
     */
    private $services;

    /**
     * @var \Webaholicson\Minimvc\Core\Router App request router
     */
    private $router;

    /**
     * @var Webaholicson\Minimvc\Core\Request App request object
     */
    private $request;

    
    /**
     * @var \Webaholicson\Minimvc\Core\Response App response object
     */
    private $response;
    
    /**
     * @var bool Indicates wether the app is running or not
     */
    private $running = false;
    
    /**
     * Initialize all private variables from context
     * 
     * @param \Webaholicson\Minimvc\Core\ContextInterface $context
     */
    public function __construct(\Webaholicson\Minimvc\Core\ContextInterface $context)
    {
        $this->config   = $context->getConfig();
        $this->services = $context->getServices();
        $this->router   = $context->getRouter();
        $this->request  = $context->getRequest();
        $this->response = $context->getResponse();
    }
    
    /**
     * Get the app request object
     * 
     * @return \Webaholicson\Minimvc\Core\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * Get the app response object
     * 
     * @return \Webaholicson\Minimvc\Core\Response
     */
    public function getResponse()
    {
        return $this->response;
        
    }
    
    /**
     * Get the app config object
     * 
     * @return \Webaholicson\Minimvc\Core\Config
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    /**
     * Get the object creation services
     * 
     * @return \Webaholicson\Minimv\Core\Services
     */
    public function getServices()
    {
        return $this->services;
    }
    
    /**
     * Get the router object
     * 
     * @return \Webaholicson\Minimv\Core\Router
     */
    public function getRouter()
    {
        return $this->router;
    }
    
    /**
     * Check if the app is running
     * 
     * @return bool
     */
    public function isRunning()
    {
        return $this->running;
    }
    
    /**
     * Run the application
     * 
     * @throws \Exception
     */
    public function run()
    {
        try {
            if ($this->isRunning()) {
                throw new \Exception('App is already running.');
            }
            $this->router->match($this->request);
            $this->response->send();
        } catch (\Exception $e) {
            echo '<pre>'.$e->getMessage().'<br/>'.$e->getTraceAsString().'</pre>';
        }
    }
}
