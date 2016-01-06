<?php
declare(strict_types = 1);
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
    public function __construct(string $method,string $path,string $scheme,string $schemeVersion,array $headers = [],string $body = '')
    {
        $this->body = $body;
        $this->setMethod($method);
        $this->setScheme($scheme);
        $this->setSchemeVersion($schemeVersion);
        $this->path = $path;
        $this->setHeaders($headers);
    }

    /**
     * @param array $headers
     */
    private function setHeaders(array $headers)
    {
        foreach($headers as $header => $value){
            $this->addHeader($header,$value);
        }
    }

    /**
     * @param $header
     * @param $value
     *
     * @throws \RuntimeException
     */
    private function addHeader(string $header,string $value)
    {
        $header = strtolower($header);
        if(isset($this->headers[$header])){
            throw new \RuntimeException(
                "Header $header is already defined you cannot set it twice"
            );
        }
        $this->headers[$header] = $value;
    }

    public function getPrologue()
    {
        return $this->method." ".$this->path." ".$this->scheme."/".$this->schemeVersion;
    }

    public static function createFromMessage(string $message)
    {
        if(!is_string($message) || empty($message)){
            throw new \MalformedHttpMessageException($message,'HTTP Message is not valid');
        }
        $lines = explode(PHP_EOL,$message);
        $result = preg_match("#^(?P<method>[A-Z]{3,7}) (?P<path>.+) (?P<scheme>HTTPS?)\/(?P<version>[1-2]\.[0-2])$#",$lines[0],$matches);
        if(!$result){
            throw new \MalformedHttpMessageException($message,'HTTP Message prologue is malformed');
        }
        array_shift($lines);
        $headers = [];
        $i = 0;
        while($line = $lines[$i]){
            $result = preg_match("#^(?P<header>[a-z][a-z0-9\-]+)\: (?P<value>.+)$#i",$line,$header);
            if(!$result){
                throw new \MalformedHttpHeaderException($message,"Invalid header line at position ".($i+2).": ".$line);
            }
            $headers[$header["header"]] = $header["value"];
            $i++;
        }
        $i++;
        $body = "";
        if(isset($lines[$i])){
            $body = $lines[$i];
        }
        return new self($matches["method"],$matches["path"],$matches["scheme"],$matches["version"],$headers,$body);
    }

    public function getMessage()
    {
        $message = $this->getPrologue();
        $message .= PHP_EOL;
        if(count($this->headers)){
            foreach($this->headers as $header => $value){
                $message .= $header.": ".$value.PHP_EOL;
            }
        }
        $message .= PHP_EOL;
        if($this->body){
            $message .= $this->body;
        }
        return $message;
    }

    public function __toString()
    {
        return $this->getMessage();
    }

    /**
     * @param $header
     * @return null or header
     */
    public function getHeader(string $header)
    {
        return ($this->headers[strtolower($header)]) ?: null;
    }

    /**
     * @param $method
     */
    private function setMethod(string $method){
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
            throw new \InvalidArgumentException("Method \"$method\" is not a supported");
        }

        $this->method = $method;
    }

    /**
     * @param $scheme
     */
    private function setScheme(string $scheme){
        $schemeArray = [
          self::HTTP,
          self::HTTPS,
        ];

        if(!in_array($scheme,$schemeArray)){
            throw new \InvalidArgumentException("Scheme \"$scheme\" is not a supported");
        }

        $this->scheme = $scheme;
    }

    private function setSchemeVersion(string $schemeVersion){
        $schemeVersionsArray = [
          self::VERSION_1_0,
          self::VERSION_1_1,
          self::VERSION_2_0,
        ];

        if(!in_array($schemeVersion,$schemeVersionsArray)){
            throw new \InvalidArgumentException("SchemeVersion \"$schemeVersion\" is not a supported");
        }

        $this->schemeVersion = $schemeVersion;
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