<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 14:48
 */

namespace Tests\Framework\Routing;
use Framework\Routing\Route;
use Framework\Routing\RouteCollection;

class RouteCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testFillRouteCollection()
    {
        $routes = new RouteCollection();
        $routes->add("home",new Route('/home'));
        $routes->add("hello",new Route('/hello'));
        $routes->add("contact",new Route('/contact'));

        $this->assertSame(3,$routes->count());
        $this->assertSame(3,count($routes));
        $this->assertCount(3,$routes);
    }

    public function testIterable()
    {
        $map = [
            "homepage" => new Route('/home'),
            "hello" => new Route('/hello'),
        ];

        $routes = new RouteCollection();

        $routes->add("homepage",$map["homepage"]);
        $routes->add("hello",$map["hello"]);

        $routes_array = [];

        foreach($routes as $name => $route){
            $routes_array[$name] = $route;
        }

        $this->assertSame($map,$routes_array);
    }
}