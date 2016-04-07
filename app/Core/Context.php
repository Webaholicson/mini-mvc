<?php
namespace Webaholicson\Minimvc\Core;

/**
 *  Abstract context class used for dependency inversion.
 * 
 *  @author Antonio Mendes <avmdausa@gmail.com>
 */
abstract class Context implements \Webaholicson\Minimvc\Core\Context\ContextInterface
{
    /**
     *  @var \Webaholicson\Minimvc\Core\Services Services object
     */
    protected $_services;
    
    /**
     *  @var \Webaholicson\Minimvc\Core\App Application object
     */
    protected $_app;
    
    /**
     *  @var \Webaholicson\Minimvc\Core\Request Main app request object
     */
    protected $_request;
    
    /**
     *  @var \Webaholicson\Minimvc\Core\Response Main app response object
     */
    protected $_response;
    
    /**
     *  @var \Webaholicson\Minimvc\Core\Config Main app config object
     */
    protected $_config;
    
    /**
     *  @var \Webaholicson\Minimvc\Core\Router Main router object
     */
    protected $_router;
    
    public function __construct(
        \Webaholicson\Minimvc\Core\Services $services,
        \Webaholicson\Minimvc\Core\Request $request,
        \Webaholicson\Minimvc\Core\Response $response,
        \Webaholicson\Minimvc\Core\Config $config,
        \Webaholicson\Minimvc\Core\Router $router
    ){
            $this->_services = $services;
            $this->_request = $request;
            $this->_response = $response;
            $this->_config = $config;
            $this->_router = $router;
    }
    
    /**
     *  Get service provider object from context
     * 
     *  @return \Webaholicson\Minimvc\Core\Services
     */
    public function getServices()
    {
        return $this->_services;
    }
    
    /**
     *  Get request object from context
     * 
     *  @return \Webaholicson\Minimvc\Core\Request
     */
    public function getRequest()
    {
        return $this->_request;
    }
    
    /**
     *  Get repsonse object from context
     * 
     *  @return \Webaholicson\Minimvc\Core\Response
     */
    public function getResponse()
    {
        return $this->_response;
    }
    
    /**
     *  Get config object from context
     * 
     *  @return \Webaholicson\Minimvc\Core\Config
     */
    public function getConfig()
    {
        return $this->_config;
    }
    
    /**
     *  Get router object from context
     * 
     *  @return \Webaholicson\Minimvc\Core\Router
     */
    public function getRouter()
    {
        return $this->_router;
    }
}
