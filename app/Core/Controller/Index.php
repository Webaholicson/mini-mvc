<?php
namespace Webaholicson\Minimvc\Core\Controller;

/**
 * Main concrete controller
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class Index extends AbstractController
{
    /**
     * Execute the action
     */
    public function execute()
    {
        $this->getResponse()->setBody($this->_view->renderView());
    }
}
