<?php
class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_HEAD = 'HEAD';
    const METHOD_TRACE = 'TRACE';
    const METHOD_PATCH = 'PATCH';

    private $body;
    private $method;
    private $scheme;
    private $schemeVersion;
    private $path;
    private $headers;

    const HTTP = 'HTTP';
    const HTTPS = 'HTTPS';

    /**
     * @param string $method            http verb
     * @param string $path              ressource path on the server
     * @param string $scheme            protocol name
     * @param string $schemeVersion     scheme version
     * @param array  $headers           all the headers
     * @param string $body              the body
     */
    public function __construct(string $method,string $path,string $scheme,string $schemeVersion,array $headers = [],string $body = ''){

        $this->body = $body;
        $this->method = $method;
        $this->scheme = $scheme;
        $this->schemeVersion = $schemeVersion;
        $this->path = $path;
        $this->headers = $headers;
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