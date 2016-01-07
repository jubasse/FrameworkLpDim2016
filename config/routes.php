<?php


use Application\Controller\HelloWorldController;
use Framework\Routing\Route;
use Framework\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add("hello",new Route('/hello',[
    '_controller' => HelloWorldController::class,
]));

return $routes;