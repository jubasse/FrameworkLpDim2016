<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 06/01/2016
 * Time: 16:46
 */

namespace Framework\Http;


interface MessageInterface
{
    const HTTP = 'HTTP';
    const HTTPS = 'HTTPS';

    const VERSION_1_0 = "1.0";
    const VERSION_1_1 = "1.1";
    const VERSION_2_0 = "2.0";

    public function getScheme();
    public function getSchemeVersion();
    public function getBody();
    public function getHeader(string $header);
    public function getHeaders();
    public function getMessage();
}