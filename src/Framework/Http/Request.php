<?php
declare(strict_types = 1);
namespace Framework\Http;
class Request extends AbstractMessage implements RequestInterface
{
    private $method;
    private $path;
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
        $this->path = $path;
        $this->setMethod($method);
        parent::__construct($scheme,$schemeVersion,$headers,$body);
    }

    public static function createFromGlobals()
    {
        $path = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : "/";
        $protocol = explode("/",$_SERVER["SERVER_PROTOCOL"]);
        return new self($_SERVER["REQUEST_METHOD"],$path,$protocol[0],$protocol[1]);
    }

    protected function createPrologue()
    {
        return $this->method." ".$this->path." ".$this->scheme."/".$this->schemeVersion;
    }

    /**
     * @param $message
     * @return mixed
     * @throws \MalformedHttpMessageException
     */
    private static function parsePrologue(string $message)
    {
        $lines = explode(PHP_EOL,$message);
        $result = preg_match("#^(?P<method>[A-Z]{3,7}) (?P<path>.+) (?P<scheme>HTTPS?)\/(?P<version>[1-2]\.[0-2])$#",$lines[0],$matches);
        if(!$result){
            throw new \MalformedHttpMessageException($message,'HTTP Message prologue is malformed');
        }
        return $matches;
    }

    /**
     * @param $message
     * @return Request
     * @throws \MalformedHttpMessageException
     */
    final public static function createFromMessage(string $message)
    {
        if(!is_string($message) || empty($message)) {
            throw new \MalformedHttpMessageException($message, 'HTTP Message is not valid');
        }
        $prologue = self::parsePrologue($message);
        return new self(
            $prologue["method"],
            $prologue["path"],
            $prologue["scheme"],
            $prologue["version"],
            static::parseHeaders($message),
            static::parseBody($message)
        );
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

    public function getPath()
    {
        return $this->path;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function send()
    {
        // TODO: Implement send() method.
    }
}