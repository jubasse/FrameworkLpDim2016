<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 10:28
 */

namespace Framework\Http;


interface StreamableInterface extends MessageInterface
{
    public function send();
}