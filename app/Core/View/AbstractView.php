<?php
namespace Webaholicson\Minimvc\Core\View;

/**
 * Abstract view for all concrete views
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
abstract class AbstractView implements \Webaholicson\Minimvc\Core\View\ViewInterface
{
    /**
     * @var string  Directory where the views are located
     */
    protected $_views;
    
    /**
     * @var array  Partials storage
     */
    protected $_parts;
    
    /**
     * @var string  Name of the phtml file to use as the template
     */
    protected $_template;
    
    /**
     * @var \Webaholicson\Minimvc\Core\Config  App config object
     */
    protected $_config;
    
    /**
     * Initialize the view
     * 
     * @param \Webaholicson\Minimvc\Core\ContextInterface $context
     * @param string $view_path
     */
    public function __construct(
        \Webaholicson\Minimvc\Core\ContextInterface $context, 
        $view_path = ''
      ) {
            $this->_config = $context->getConfig();
            $this->_parts = array();
            $this->init($view_path);
      }
    
    /**
     * Initialize the view
     * 
     * @param string $view_path
     * @return \Webaholicson\Minimvc\Core\View\AbstractView
     */
    public function init($view_path)
    {
        $this->_views = $view_path;

        if (!$view_path) {
            $this->_views = BP . DS . 'views' . DS;
        }

        return $this;
    }
    
    /**
     * Render the output and return it
     * 
     * @param string $template
     * @param array $vars
     * @return string
     * @throws \Exception
     */
    public function renderView($vars = array())
    {
        $file = $this->_views.$this->_template.'.'.$this->_config->get('general')->get('template_engine');

        if (!is_file($file)) {
            throw new \Exception(sprintf('Template file not found: %s', $file));
        }
        
        extract($vars);
        ob_start();
        require_once $file;
        $output = ob_get_clean();
        return $output;
    }
    
    /**
     * Add a partial to this view
     * 
     * @param string $name
     * @param \Webaholicson\Minimvc\Core\View\ViewInterface $view
     */
    public function addPart(
        $name, 
        \Webaholicson\Minimvc\Core\View\ViewInterface $view)
    {
        $this->_parts[$name] = $view;
    }
    
    /**
     * Render the output for a part inside this view
     * 
     * @param string $name
     * @return string
     */
    public function getPartial($name)
    {
        if (isset($this->_parts[$name])) {
            return $this->_parts[$name]->renderView(array('parent' => $this));
        }
        
        return '';
    }
    
    /**
     * Get all the parts associated with this view.
     * 
     * @return array
     */
    public function getParts()
    {
        return $this->_parts;
    }
    
    /**
     * Set the template to use for this view
     * 
     * @param type $template
     * @return \Webaholicson\Minimvc\Core\View\AbstractView
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
        return $this;
    }
    
    /**
     * Generate and fetch url
     * 
     * @param string $path
     * @return string
     */
    public function getUrl($path = '')
    {
        return rtrim($this->_config->get('general')->get('base_url'), '/') . '/' .$path;
    }
}