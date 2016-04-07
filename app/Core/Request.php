<?php
namespace Webaholicson\Minimvc\Core;

class Request
{
    /**
     * @var array Options from the config
     */
    private $options;
    
    /**
     * @var array Request headers
     */
    protected $_headers = array();

    /**
     * @var string Request uri
     */
    protected $_path;
    
    /**
     * @var string Request method
     */
    protected $_method;
    
    /**
     * @var string Request url query string
     */
    protected $_query;

    /**
     * @var string Request scheme
     */
    protected $_scheme;
    
    /**
     * @var string Server host name 
     */
    protected $_host;
    
    /**
     * @var string Applications base uri
     */
    protected $_baseUri;
    
    /**
     * Instantiate the class and parse the url string if there is one.
     * @param string $url
     */
    public function __construct($url = '')
    {
        if ($url) {
            $options = parse_url($url);
            array_walk($options, function($value, &$key) {
                $key = '_' . $key;
            });
            
            $this->init($options);
        }
        
         if (!$this->options) {
                include 'config/config.php';
                $this->init($config['request']->get());
            }
    }
    
    /**
     * Initialize the request using an array of options
     * 
     * @param array $options
     * @return \Webaholicson\Minimvc\Core\Request
     */
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
    
    /**
     * Normalize the uri so it matches registered routes
     */
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
    
    /**
     * Retrieve the uri
     * 
     * @return string
     */
    public function getUri()
    {
        return $this->_path;
    }
    
    /**
     * Get a post variable or all of them
     * 
     * @param string|null $key
     * @return mixed
     */
    public function getPost($key = null)
    {
        if (is_null($key)) {
            return $_POST;
        }
        
        return isset($_POST[$key])  ? $_POST[$key] : '';
    }
    
    /**
     * Get all request variables
     * 
     * @return array
     */
    public function getParams()
    {
        return $_REQUEST;
    }
    
    /**
     * Retrieve a GET variable
     * 
     * @param string $key
     * @return mixed
     */
    public function getParam($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : '';
    }
    
    /**
     * Check if the request is a POST request
     * 
     * @return bool
     */
    public function isPost()
    {
        return $this->_method == 'POST';
    }
    
    /**
     * Check if the request is a GET request
     * 
     * @return bool
     */
    public function isGet()
    {
        return $this->_method == 'GET';
    }
}
