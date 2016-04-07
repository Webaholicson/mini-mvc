<?php
namespace Webaholicson\Minimvc\Core\Controller;

/**
 * Abstract controller which all controllers are extended by
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

    public function __construct(
        \Webaholicson\Minimvc\Core\Context\ContextInterface $context,
        \Webaholicson\Minimvc\Core\View\ViewInterface $view
    ) {
            $this->_config = $context->getConfig();
            $this->_request = $context->getRequest();
            $this->_response = $context->getResponse();
            $this->_view = $view;
    }
    
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
