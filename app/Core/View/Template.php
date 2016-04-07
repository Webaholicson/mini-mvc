<?php
namespace Webaholicson\Minimvc\Core\View;

/**
 * Default concrete view.
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class Template extends AbstractView
{
    protected $_parts;
    
    /**
     * Get template part
     * 
     * @param string $name
     * @return string
     */
    public function getPartial($name)
    {
        if (!isset($this->parts['name'])) {
            return '';
        }
    }
}
