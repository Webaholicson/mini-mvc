<?php
namespace \Webaholicson\Minimvc\Core\Controller;

class NoRoute extends \Webaholicson\Minimvc\Core\Controller
{
    public function execute()
    {
        $template_vars = array(
            'home_url' => $this->app->getConfigValue('base_url')
        );

        $this->getResponse()
            ->setStatusCode(404)
            ->setReasonPhrase('Not Found')
            ->setBody($this->view->renderView('404', $template_vars));
      }
}
