<?php
namespace Webaholicson\Minimvc\Core\View;

/**
 * Abstract view for all concrete views
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
abstract class AbstractView implements \Webaholicson\Minimvc\Core\View\ViewInterface
{
    protected $_views;

    public function __construct(
        \Webaholicson\Minimvc\Core\Context\ContextInterface $context, 
        $view_path = ''
      ) {
          $this->_config = $context->getConfig();
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
    public function renderView($template, $vars = array())
    {
        $file = $this->_views.$template.'.'.$this->config->get('template_engine');

        if (!is_file($file)) {
            throw new \Exception(sprintf('Template file not found: %s', $file));
        }

        extract($vars);
        ob_start();
        require_once $file;
        $output = ob_get_clean();
        return $output;
    }
}