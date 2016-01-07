<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 14:21
 */

namespace Framework\Routing;


class Router implements RouterInterface
{
    /**
     * @var Route[]
     */
    private $routes;

    /**
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param $path
     * @return array
     * @throws RouterNotFoundException
     */
    public function match(string $path)
    {
        if(!$route = $this->routes->match($path)){
            throw new RouterNotFoundException("Not route found for path '$path'.");
        }
        return $route->getParameters();
    }

    /**
     * @return mixed
     */
    public function getRoutes()
    {
        return ($this->routes) ?: null;
    }
}