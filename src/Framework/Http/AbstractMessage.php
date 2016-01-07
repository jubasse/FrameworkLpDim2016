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
    /**
     * @var Header[]
     */
    protected $headers;
    protected $body;

    public function __construct(string $scheme,$schemeVersion,$headers,$body)
    {
        $this->headers = [];
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
        if($header = $this->findHeader($header)){
            return $header->getValue();
        }
    }

    /**
     * @param $name
     * @return Header
     */
    private function findHeader(string $name)
    {
        foreach($this->headers as $header){
            if($header->match($name)){
                return $header;
            }
        }
    }

    public function getHeaders()
    {
        $headers = [];
        foreach($this->headers as $header){
            $headers = array_merge($headers,$header->toArray());
        }
        return $headers;
    }

    /**
     * @param $name
* @param $value
*
* @throws \RuntimeException
*/
    private function addHeader(string $name,$value)
    {
        if($this->findHeader($name)){
            throw new \RuntimeException(
                "Header $name is already defined you cannot set it twice"
            );
        }
        $this->headers[] = new Header($name,(string) $value);
    }

    protected abstract function createPrologue();

    final public function getMessage()
    {
        $message = $this->createPrologue();
        $message .= PHP_EOL;
        if(count($this->headers)){
            foreach($this->headers as $header){
                $message .= (string) $header.PHP_EOL;
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
            $headers = array_merge($headers,static::parseHeader($lines[$i],$i));
            $i++;
        }
        return $headers;
    }

    private static function parseHeader($line,$position)
    {
        try{
            return $header = Header::createFromString($line)->toArray();
        } catch(MalformedHttpHeaderException $e){
            throw new MalformedHttpHeaderException(
                "Invalid header line at position ".($position+2).": ".$line,
                0,
                $e
            );
        }
    }

    public function __toString()
    {
        return $this->getMessage();
    }
}