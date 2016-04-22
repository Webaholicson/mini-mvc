<?php
namespace Webaholicson\Minimvc\Page\Controller;

/**
 * View for the 404 page
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class NoRoute extends Index
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        parent::_prepareView();
        
        $this->getResponse()
            ->setStatusCode(404)
            ->setReasonPhrase('Not Found')
            ->setBody($this->_view->setTemplate('404')->renderView());
      }
}