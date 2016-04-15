<?php
namespace Webaholicson\Minimvc\Core;

/**
 *  Initiates the entire process
 * 
 *  @author Antonio Mendes <webaholicson@gmail.com>
 */
final class Bootstrap
{
    /**
     * @var \Webaholicson\Minimvc\Core\App  Application object
     */
    private $app;
    
    /**
     * @var \Webaholicson\Minimvc\Core\ContextInterface  Main context object
     */
    private $context;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Services  Main service provider object
     */
    private $services;
    
    /**
     * Initialize services
     * 
     * @param \Webaholicson\Minimvc\Core\Services $services
     */
    public function __construct(\Webaholicson\Minimvc\Core\Services $services) 
    {
        $this->services = $services;
    }
    
    /**
     *  Initialize the main context object
     * 
     *  @return void
     */
    private function initContext()
    {
        $this->context = $this->services
            ->getObject('Webaholicson\Minimvc\Core\ContextInterface', [
                'services' => $this->services,
            ], true);
    }
    
    /**
     * Register function for autoloading classes
     * 
     * @param string $className
     * @return void 
     */
    public function autoload($className)
    {
        $filePath = str_replace('Webaholicson'.DS.'Minimvc'.DS, '', strtr(
            ltrim($className, '\\'),
            array(
                '\\' => DS,
                '_'  => DS
            )
        ));

        include_once $filePath . '.php';
    }
    
    /**
     *  Create app instannce and return it
     * 
     *  @param array $options
     *  @return \Webaholicson\Minimvc\Core\App
     */
    public function init($options = [])
    {  
        spl_autoload_register(array($this, 'autoload'));
        $this->initContext();
        $this->app = $this->services->getObject('Webaholicson\Minimvc\Core\App', [
            'context' => $this->context
        ], true);
        
        if (isset($options['config'])) {
            $this->app->getConfig()->init($options['config']);
        }
        
        if (isset($options['request'])) {
            $this->app->getRequest()->init($options['request']);
        }
        
        if (isset($options['routes'])) {
            $this->app->getRouter()->init($options['routes']);
        }
        
        return $this->app;
    }
}