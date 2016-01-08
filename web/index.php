<?php
require_once __DIR__."/../vendor/autoload.php";

use Framework\ControllerFactory;
use Framework\Http\Request;
use Framework\Http\StreamableInterface;
use Framework\Kernel;
use Framework\Routing\Loader\CompositeFileLoader;
use Framework\Routing\Loader\PhpFileLoader;
use Framework\Routing\Loader\XmlFileLoader;
use Framework\Routing\Router;

$loader = new CompositeFileLoader();
$loader->add(new PhpFileLoader());
$loader->add(new XmlFileLoader());

$router = new Router(__DIR__."/../config/routes.xml",$loader);
$kernel = new Kernel($router,new ControllerFactory());
$response = $kernel->handle(Request::createFromGlobals());

if($response instanceof StreamableInterface){
    $response->send();
}