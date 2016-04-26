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
     * @var array   HTTP response headers
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
     * Class constructor initializes the headers array
     * 
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->headers = array();
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
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Send the HTTP headers
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
            $this->_responsePhrase
        )), true, $this->_statusCode);

        if ($this->_headers) {
            foreach ($this->headers as $key => $value) {
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
    
    /**
     * Send the response back to the client
     * @return void
     */
    public function send()
    {
        http_response_code($this->_statusCode);
        $this->_sendHeaders();
        echo $this->_body;
    }
}
