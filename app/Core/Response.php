<?php
namespace Webaholicson\Minimvc\Core;

/**
 * HTTP Response class
 * 
 * @author Antonio Mendes <webaholicson@gmail.com>
 */
class Response
{
    /**
     * List of all known HTTP response codes - used to
     * translate numeric codes to messages.
     *
     * @var array
     */
    protected static $_messages = [
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',

        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',  // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',

        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',

        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    ];
    
    /**
     * @var array   HTTP response _headers
     */
    protected $_headers;
    
    /**
     * @var string   HTTP response verison header
     */
    protected $_httpVersion = 'HTTP/1.1';
    
    /**
     * @var string   HTTP response reason phrase
     */
    protected $_responsePhrase = 'OK';
    
    /**
     * @var string   HTTP response status code
     */
    protected $_statusCode = 200;
    
    /**
     * @var string   HTTP response body
     */
    protected $_body;

    /**
     * Class constructor initializes the _headers array
     * 
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->_headers = array();
    }
    
    /**
     * Set an HTTP header on the response object
     * 
     * @param string $key
     * @param string $value
     * @return \Webaholicson\Minimvc\Core\Response
     */
    public function setHeader($key, $value)
    {
        $this->_headers[$key] = $value;
        return $this;
    }
    
    public function getHeader($key)
    {
        return isset($this->_headers[$key]) ? $this->_headers[$key] : '';
    }

    /**
     * Send the HTTP _headers
     * 
     * @throws \Exception
     */
    protected function _sendHeaders()
    {
        if (headers_sent($file, $line)) {
            throw new \Exception(sprintv(
                "Headers already send on file %s and line %s.",
                array($file, $line)
            ));
        }

        header(vsprintf("%s %s %s", array(
            $this->_httpVersion,
            $this->_statusCode,
            self::$_messages[$this->_statusCode]
        )), true, $this->_statusCode);

        if ($this->_headers) {
            foreach ($this->_headers as $key => $value) {
                header("$key: $value");
            }
        }
    }
    
    /**
     * Set the HTTP version for the resposne
     * 
     * @param string $version
     * @return \Webaholicson\Minimvc\Core\Response
     */
    public function setHttpVersion($version)
    {
        $this->_httpVersion = $version;
        return $this;
    }
    
    public function getHttpVersion()
    {
        return $this->_httpVersion;
    }
    
    /**
     * Set the HTTP status code on the response
     * 
     * @param int $code
     * @return \Webaholicson\Minimvc\Core\Response
     */
    public function setStatusCode($code)
    {
        $this->_statusCode = $code;
        return $this;
    }
    
    public function getStatusCode()
    {
        return $this->_statusCode;
    }
    
    /**
     * Set the HTTP reason phrase on the response
     * 
     * @param string $phrase
     * @return \Webaholicson\Minimvc\Core\Response
     */
    public function setReasonPhrase($phrase)
    {
        $this->_responsePhrase = $phrase;
        return $this;
    }
    
    public function getReasonPhrase()
    {
        return $this->_responsePhrase;
    }
    
    /**
     * Set the response body
     * 
     * @param string $body
     * @return \Webaholicson\Minimvc\Core\Response
     */
    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }
    
    public function getBody()
    {
        return $this->_body;
    }
    
    /**
     * Send the response back to the client
     */
    public function send()
    {
        http_response_code($this->_statusCode);
        $this->_sendHeaders();
        echo $this->_body;
    }
}
