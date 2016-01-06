<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 06/01/2016
 * Time: 16:52
 */

namespace Framework\Http;


interface ResponseInterface extends MessageInterface
{
    public function getStatusCode();
    public function getReasonPhrase();
}