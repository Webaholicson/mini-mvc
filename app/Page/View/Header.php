<?php
namespace Webaholicson\Minimvc\Page\View;

/**
 * View class for the header
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class Header extends \Webaholicson\Minimvc\Core\View\AbstractView
{
    protected $_template = 'header';
    
    public function getLogoSrc()
    {
        return $this->getUrl('images/logo.jpg');
    }
}