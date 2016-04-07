<?php
namespace Webaholicson\Minimvc\Core;

class Request
{
    private $options;

    protected $_headers = array();

    protected $_path;

    protected $_method;

    protected $_query;

    protected $_scheme;

    protected $_host;

    protected $_baseUri;

    public function __construct($url = '')
    {
        if ($url) {
            $options = parse_url($url);
            array_walk($options, function($value, &$key) {
                $key = '_' . $key;
            });
            
            $this->init($options);
        }
    }
    
    public function init($options)
    {
        if (!$options) {
            return $this;
        }
        
        $this->options = $options;

        foreach ($options as $key => $value) {
            if (property_exists('Request', '_'.$key)) {
                $this->key = $value;
            }
        }

        $this->_normalizeUri();
        return $this;
    }

    protected function _normalizeUri()
    {
        $parts = explode('?', $this->options['path']);
        $this->options['path'] = $parts[0];

        if (substr($this->options['path'], -1) == '/') {
            $this->_path = substr($this->options['path'], 0, -1);
        } else {
            $this->_path = $this->options['path'];
        }

        $this->_path = str_replace(
            $this->options['baseUri'],
            '',
            $this->_path
        );

        if (!$this->_path) $this->_path = '/';
    }

    public function getUri()
    {
        return $this->_path;
    }

    public function getPost($key = null)
    {
        if (is_null($key)) {
            return $_POST;
        }
        
        return isset($_POST[$key])  ? $_POST[$key] : '';
    }
    
    public function getParams()
    {
        return $_REQUEST;
    }
    
    public function getParam($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : '';
    }

    public function isPost()
    {
        return $this->_method == 'POST';
    }

    public function isGet()
    {
        return $this->_method == 'GET';
    }
}
