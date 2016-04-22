<?php
namespace Webaholicson\Minimvc\Core\Controller;

/**
 * Abstract controller which all controllers extend from
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
abstract class AbstractController implements \Webaholicson\Minimvc\Core\Controller\ControllerInterface
{
    /**
     * @var \Webaholicson\Minimvc\Core \Config
     */
    protected $_config;
    
    /**
     * @var \Webaholicson\Minimvc\Core\View\ViewInterface
     */
    protected $_view;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Request
     */
    protected $_request;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Response
     */
    protected $_response;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Services
     */
    protected $_services;

    /**
     * @var \Webaholicson\Minimvc\Core\View\ViewInterface Layout view to use for this controller
     */
    protected $_layout;
    
    public function __construct(
        \Webaholicson\Minimvc\Core\ContextInterface $context,
        \Webaholicson\Minimvc\Core\View\ViewInterface $view
    ) {
            $this->_config = $context->getConfig();
            $this->_request = $context->getRequest();
            $this->_response = $context->getResponse();
            $this->_services = $context->getServices();
            $this->_view = $view;
    }
    
    /**
     *  Execute the request and prepare response
     *  @return void
     */
    abstract public function execute();

    /**
     *  Code to run before the action gets dispatched
     *  @return void
     */
    protected function _preDispatch()
    {
        $this->getResponse()
            ->setStatusCode(200)
            ->setReasonPhrase('OK');
    }
    
    /**
     *  Code to run after the action gets dispatched
     *  @return void
     */
    protected function _postDispatch()
    {
        // Not yet implemented
    }
    
    /**
     * Add a template part to the main view
     * 
     * @param string $name
     * @param string $className
     */
    protected function _addViewPart($name, $className)
    {
        $this->_view->addPart(
            $name, 
            $this->_services->getObject($className, [
                'context' => $this->_services->getObject('Webaholicson\Minimvc\Core\Context', [], true)
            ])
        );
    }
    
    /**
     * Prepare the view for rendering
     * 
     * @return \Webaholicson\Minimvc\Core\View\ViewInterface
     */
    protected function _prepareView()
    {
        return $this->_view;
    }


    /**
     *  Execute the action
     *  @return void
     */
    public function dispatch()
    {
        $this->_preDispatch();
        $this->execute();
        $this->_postDispatch();
    }
    
    /**
     * Get the current request object
     * 
     * @return \Webaholicson\Minimvc\Core\Request
     */
    public function getRequest()
    {
        return $this->_request;
    }
    
    /**
     * Get the current response object
     * 
     * @return \Webaholicson\Minimvc\Core\Response
     */
    public function getResponse()
    {
        return $this->_response;
    }
}
