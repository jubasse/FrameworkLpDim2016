<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 06/01/2016
 * Time: 15:34
 */

namespace Framework\Http;


class Response extends AbstractMessage
{
    public $statusCode;

    private static $reason_phrases = [
      200 => 'Ok',
      201 => 'Created',
      202 => 'Accepted',
      301 => 'Moved Permanently',
      302 => 'Moved Temporarily',
      304 => 'Not modified',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment required',
      403 => 'Required',
      404 => 'Page Not Found',
      405 => 'Method Not Found',
      406 => 'Not Acceptable',
      418 => 'I\'m a teapot',
      451 => 'Unavailable For Legal Reasons',
      500 => 'Internal Server Error',
      502 => 'Bad Gateway',
      503 => 'Service Unavailable',

    ];

    public function __construct($statusCode,$scheme,$schemeVersion, array $headers,$body)
    {
        parent::__construct($scheme,$schemeVersion,$headers,$body);

        $this->setStatusCode($statusCode);
    }

    private function setStatusCode($statusCode)
    {
        $statusCode = (int) $statusCode;
        if($statusCode < 100 || $statusCode > 599){
            throw new \InvalidArgumentException('Invalid status code');
        }
        $this->statusCode = $statusCode;
    }

    private static function parsePrologue($message)
    {
        $lines = explode(PHP_EOL,$message);
        $result = preg_match("#^(?P<scheme>HTTPS?)\/(?P<version>[1-2]\.[0-2]) (?P<status>[1-5][0-9]{2})#",$lines[0],$matches);
        if(!$result){
            throw new \MalformedHttpMessageException($message,'HTTP Message prologue is malformed');
        }
        return $matches;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return ($this->statusCode) ?: null;
    }

    public function getReasonPhrase()
    {
        return (self::$reason_phrases[$this->statusCode]) ?: '';
    }

    protected function createPrologue()
    {
        return $this->scheme."/".$this->schemeVersion." ".$this->statusCode." ".$this->getReasonPhrase();
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
            $prologue["status"],
            $prologue["scheme"],
            $prologue["version"],
            static::parseHeaders($message),
            static::parseBody($message)
        );
    }
}