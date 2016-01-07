<?php

use Framework\Http\Request;
use Framework\Http\StreamableInterface;
use Framework\Kernel;

require_once __DIR__."/../vendor/autoload.php";

$path = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : "/";
$protocol = explode("/",$_SERVER["SERVER_PROTOCOL"]);
$request = new Request($_SERVER["REQUEST_METHOD"],$_SERVER["REQUEST_URI"],$protocol[0],$protocol[1]);
$kernel = new Kernel();
$response = $kernel->handle($request);
if($response instanceof StreamableInterface){
    $response->send();
}