<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 06/01/2016
 * Time: 10:47
 */

namespace Framework\Http;

class MalformedHttpMessageException extends \RuntimeException
{
    private $httpMessage;
    public function __construct($httpMessage, $message = "", \Exception $previous = null)
    {
        parent::__construct($message,0,$previous);

        $this->httpMessage = $httpMessage;
    }

    public function getHttpMessage()
    {
        return $this->httpMessage ?: null;
    }
}