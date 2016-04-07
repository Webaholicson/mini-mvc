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
        $template_vars = array(
            'home_url' => $this->_config->get('base_url')
        );
        
        $this->getResponse()->setBody($this->_view->renderView($template_vars));
    }
}
