<?php

use Framework\Http\Request;
use Framework\Http\StreamableInterface;
use Framework\Kernel;
use Framework\Routing\Router;

require_once __DIR__."/../vendor/autoload.php";

$router = new Router(include(__DIR__."/../config/routes.php"));
$kernel = new Kernel($router);

$response = $kernel->handle(Request::createFromGlobals());

if($response instanceof StreamableInterface){
    $response->send();
}