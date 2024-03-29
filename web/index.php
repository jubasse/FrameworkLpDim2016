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
use Framework\Templating\BracketRenderer;
use Framework\Templating\PhpRenderer;

$loader = new Twig_Loader_Filesystem(__DIR__.'/../app/views');
$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__.'/../app/cache/twig',
    'debug' => true,
));

$renderer = new PhpRenderer(__DIR__."/../app/views");
$renderer = new BracketRenderer(__DIR__.'/../app/views');
$renderer = new \Framework\Templating\TwigRendererAdapter($twig);

$loader = new CompositeFileLoader();
$loader->add(new PhpFileLoader());
$loader->add(new XmlFileLoader());

$router = new Router(__DIR__."/../app/config/routes.xml",$loader);
$kernel = new Kernel($router,new ControllerFactory(),$renderer);

$response = $kernel->handle(Request::createFromGlobals());

if($response instanceof StreamableInterface){
    $response->send();
}