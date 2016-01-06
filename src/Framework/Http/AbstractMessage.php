<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 06/01/2016
 * Time: 11:41
 */

namespace Framework\Http;


abstract class AbstractMessage implements MessageInterface
{
    protected $scheme;
    protected $schemeVersion;
    protected $headers;
    protected $body;

    public function __construct(string $scheme,$schemeVersion,$headers,$body)
    {
        $this->setHeaders($headers);
        $this->setScheme($scheme);
        $this->setSchemeVersion($schemeVersion);
        $this->body = $body;
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

    /**
     * @param array $headers
     */
    private function setHeaders(array $headers)
    {
        foreach($headers as $header => $value){
            $this->addHeader($header,$value);
        }
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

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getSchemeVersion()
    {
        return $this->schemeVersion;
    }

    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $header
     * @return null or header
     */
    public function getHeader(string $header)
    {
        return ($this->headers[strtolower($header)]) ?: null;
    }

    public function getHeaders()
    {
        return $this->headers;
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

    protected abstract function createPrologue();

    final public function getMessage()
    {
        $message = $this->createPrologue();
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

    protected static function parseBody(string $message)
    {
        $pos = strpos($message,PHP_EOL.PHP_EOL);
        return (string) (substr($message, $pos+4));
    }

    protected static function parseHeaders($message)
    {
        $start = strpos($message,PHP_EOL) + 2;
        $end = strpos($message,PHP_EOL.PHP_EOL);
        $length = $end - $start;
        $lines = explode(PHP_EOL,substr($message, $start, $length));

        $i = 0;
        $headers = [];
        while(!empty($lines[$i])){
            $line = $lines[$i];
            $result = preg_match("#^(?P<header>[a-z][a-z0-9\-]+)\: (?P<value>.+)$#i",$line,$header);
            if(!$result){
                throw new MalformedHttpHeaderException("Invalid header line at position ".($i+2).": ".$line);
            }
            $headers[$header["header"]] = $header["value"];
            $i++;
        }
        return $headers;
    }

    public function __toString()
    {
        return $this->getMessage();
    }
}