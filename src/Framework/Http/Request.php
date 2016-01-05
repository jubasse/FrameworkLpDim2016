<?php
namespace Framework\Http;
class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_CONNECT = 'CONNECT';
    const METHOD_HEAD = 'HEAD';
    const METHOD_TRACE = 'TRACE';
    const METHOD_PATCH = 'PATCH';

    const HTTP = 'HTTP';
    const HTTPS = 'HTTPS';

    const VERSION_1_0 = "1.0";
    const VERSION_1_1 = "1.1";
    const VERSION_2_0 = "2.0";

    private $body;
    private $method;
    private $scheme;
    private $schemeVersion;
    private $path;
    private $headers;
    /**
     * @param $method
     * @param $path
     * @param $scheme
     * @param $schemeVersion
     * @param array $headers
     * @param $body
     */
    public function __construct(string $method,string $path,string $scheme,string $schemeVersion,array $headers = [],string $body = ''){

        $this->body = $body;
        $this->setMethod($method);
        $this->setScheme($scheme);
        $this->schemeVersion = $schemeVersion;
        $this->path = $path;
        $this->headers = $headers;
    }

    /**
     * @param $method
     */
    private function setMethod($method){
        $methodArray = [
          self::METHOD_HEAD,
          self::METHOD_GET,
          self::METHOD_POST,
          self::METHOD_PUT,
          self::METHOD_CONNECT,
          self::METHOD_OPTIONS,
          self::METHOD_DELETE,
          self::METHOD_TRACE,
          self::METHOD_PATCH,
        ];

        if(!in_array($method,$methodArray)){
            throw new \InvalidArgumentException("Method \"$method\" is not a supported HTTP method");
        }

        $this->method = $method;
    }

    /**
     * @param $scheme
     */
    private function setScheme($scheme){
        $schemeArray = [
          self::HTTP,
          self::HTTPS,
        ];

        if(!in_array($scheme,$schemeArray)){
            throw new \InvalidArgumentException("Scheme \"$scheme\" is not a supported HTTP method");
        }

        $this->scheme = $scheme;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getSchemeVersion()
    {
        return $this->schemeVersion;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}