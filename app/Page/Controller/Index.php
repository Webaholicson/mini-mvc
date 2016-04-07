<?php
namespace Webaholicson\Minimvc\Page\Controller;

class Index extends \Webaholicson\Minimvc\Core\Controller\Index
{
    public function execute()
    {
        $template_vars = array(
            'home_url' => $this->_config->get('base_url')
        );

        $this->getResponse()->setBody($this->_view->renderView('index', $template_vars));
    }
}
