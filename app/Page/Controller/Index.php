<?php
namespace Webaholicson\Minimvc\Page\Controller;

/**
 * Main page controller action
 * @autho Antonio Mendes <webaholicson@gmail.com>
 */
class Index extends \Webaholicson\Minimvc\Core\Controller\Index
{
    /**
     * {@inheritdoc}
     */
    public function execute() 
    {
        $this->_prepareView();
        parent::execute();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _prepareView()
    {
        $this->_addViewPart('head', 'Webaholicson\Minimvc\Page\View\Head');
        $this->_addViewPart('header', 'Webaholicson\Minimvc\Page\View\Header');
        $this->_addViewPart('content', 'Webaholicson\Minimvc\Page\View\Content');
        $this->_addViewPart('footer', 'Webaholicson\Minimvc\Page\View\Footer');
        return parent::_prepareView();
    }
}
