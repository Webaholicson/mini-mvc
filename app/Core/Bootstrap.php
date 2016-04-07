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
     * @var \Webaholicson\Minimvc\Core\Context\ContextInterface  Main context object
     */
    private $context;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Services  Main service provider object
     */
    private $services;
    
    /**
     *  Initialize the service object.
     * 
     *  @return  void
     */
    private function initServices()
    {
        $this->services = new \Webaholicson\Minimvc\Core\Services();
    }
    
    /**
     *  Initialize the main context object
     * 
     *  @return void
     */
    private function initContext()
    {
        $this->context = $this->services
            ->getObject('Webaholicson\Minimvc\Core\Context\ContextInterface', [
                'services' => $this->services,
            ], true);
    }
    
    /**
     * Register function for autoloading classes
     * 
     * @param string $className
     * @return void 
     */
    private function autoload($className)
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
     *  @return \Webaholicson\Minimvc\Core\App
     */
    public function init()
    {
        spl_autoload_register(array($this, 'autoload'));
        $this->initServices();
        $this->initContext();
        $this->app = $this->services->getObject('Webaholicson\Minimvc\Core\App', [
            'context' => $this->context
        ], true);
        return $this->app;
    }
}
