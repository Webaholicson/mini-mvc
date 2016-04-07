<?php
namespace Webaholicson\Minimvc\Page\Controller;

class NoRoute extends \Webaholicson\Minimvc\Core\Controller\Index
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        $template_vars = array(
            'home_url' => $this->_config->get('base_url')
        );

        $this->getResponse()
            ->setStatusCode(404)
            ->setReasonPhrase('Not Found')
            ->setBody($this->_view->renderView('404', $template_vars));
      }
}
