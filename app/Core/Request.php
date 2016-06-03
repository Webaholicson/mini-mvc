<?php
namespace Webaholicson\Minimvc\Core;

class Request
{
    /**
     * Options from the config
     * 
     * @var array
     */
    private $options;
    
    /**
     * Request headers
     * 
     * @var array
     */
    protected $_headers = array();

    /**
     * Request uri
     * 
     * @var string
     */
    protected $_path;
    
    /**
     * Request method
     * 
     * @var string
     */
    protected $_method;
    
    /**
     * Request url query string
     * 
     * @var string
     */
    protected $_query;

    /**
     * Request scheme
     * 
     * @var string
     */
    protected $_scheme;
    
    /**
     * Server host name 
     * 
     * @var string
     */
    protected $_host;
    
    /**
     * Applications base uri
     * 
     * @var string
     */
    protected $_baseUri;
    
    /**
     * Request referrer URL
     * 
     * @var string
     */
    protected $_referrer;
    
    /**
     * Original url
     * 
     * @var string
     */
    protected $_original;
    
    /**
     * Instantiate the class and parse the url string if there is one.
     * @param string $url
     */
    public function __construct($url = '')
    {
        if ($url) {
            $this->_original = $url;
            $options = parse_url($url);
            array_walk($options, function($value, &$key) {
                $key = '_' . $key;
            });
            
            $this->init($options);
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
        $this->_path = $this->options['path'];
        
        if (substr($this->options['path'], -1) == '/') {
            $this->_path = substr($this->options['path'], 0, -1);
        }
        
        if (isset($this->options['baseUri'])) {
            $this->_path = '/' . ltrim(str_replace(
                array($this->options['baseUri'], 'index.php'),
                array('', ''),
                $this->_path
            ), '/');
        }

        if (!$this->_path) {
            $this->_path = '/';
        }
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
    
    public function setUri($uri)
    {
        $this->_path = $uri;
        return $this;
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
        
        return isset($_POST[$key])  ? $_POST[$key] : null;
    }
    
    /**
     * Set a value to the POST supergloal
     * 
     * @param string $key
     * @param mixed $value
     * @return \Webaholicson\Minimvc\Core\Request
     */
    public function setPost($key, $value)
    {
        $_POST[$key] = $value;
        return $this;
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
     * @param string|null $key
     * @return mixed
     */
    public function getParam($key = null)
    {
        if (is_null($key)) {
            return $_GET;
        }
        
        return isset($_GET[$key])  ? $_GET[$key] : null;
    }
    
    /**
     * Set a parameter to the GET superglobal
     * 
     * @param string $key
     * @param mixed $value
     * @return \Webaholicson\Minimvc\Core\Request
     */
    public function setParam($key, $value)
    {
        $_GET[$key] = $value;
        return $this;
    }
    
    /**
     * Set the request method
     * 
     * @param string $method
     * @return \Webaholicson\Minimvc\Core\Request
     */
    public function setMethod($method)
    {
        $this->_method = $method;
        return $this;
    }
    
    /**
     * Get the request method. GET is the default.
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->_method ? $this->_method : 'GET';
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
    
    /**
     * Return the query string
     * 
     * @return string
     */
    public function getQuery()
    {
        return $this->_query;
    }
    
    /**
     * Return the host address
     * 
     * @return string
     */
    public function getHost()
    {
        return $this->_host;
    }
    
    /**
     * Set the host address of the request
     * 
     * @param string $host
     * @return \Webaholicson\Minimvc\Core\Request
     */
    public function setHost($host)
    {
        $this->_host = $host;
        return $this;
    }
    
    /**
     * Set the request scheme
     * 
     * @param string $scheme
     * @return \Webaholicson\Minimvc\Core\Request
     */
    public function setScheme($scheme)
    {
        $this->_scheme = $scheme;
        return $this;
    }
    
    /**
     * Get the request scheme (HTTP or HTTPS)
     * 
     * @return string
     */
    public function getScheme()
    {
        return $this->_scheme;
    }
    
    /**
     * Get the referrer url
     * 
     * @return string
     */
    public function getReferrer()
    {
        return $this->_referrer;
    }
    
    /**
     * Get header value
     * 
     * @param string $key
     * @return string
     */
    public function getHeader($key)
    {
        return isset($this->_headers[$key]) ? $this->_headers[$key] : '';
    }
    
    /**
     * Set header value
     * 
     * @param string $key
     * @param string $value
     * @return \Webaholicson\Minimvc\Core\Request
     */
    public function setHeader($key, $value)
    {
        $this->_headers[$key]  = $value;
        return $this;
    }
    
    /**
     * Send the request
     * 
     * @return mixed
     */
    public function send()
    {
        $ch = curl_init($this->_scheme . '://' . $this->_host . $this->_path . $this->_query);
        
        if ($this->isPost()) {
            curl_setopt($ch, CURLOPT_POST, true);
        }
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getParams());
        
        if ($this->_headers) {
            $headers = array();
            foreach ($this->_headers as $key => $val) {
                $headers[] = $key . ': ' . $val;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}