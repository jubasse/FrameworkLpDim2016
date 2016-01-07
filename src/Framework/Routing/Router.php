<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 14:21
 */

namespace Framework\Routing;


use Framework\Routing\Loader\FileLoaderInterface;

class Router implements RouterInterface
{
    /**
     * @var Route[]
     */
    private $routes;
    private $configuration;
    private $loader;

    /**
     * @param $configuration
     * @param FileLoaderInterface $loader
     * @internal param RouteCollection $routes
     */
    public function __construct(string $configuration,FileLoaderInterface $loader)
    {
        $this->configuration = $configuration;
        $this->loader = $loader;
    }

    /**
     * @param $path
     * @return array
     * @throws RouterNotFoundException
     */
    public function match(string $path)
    {
        if($this->routes === null){
            $this->routes = $this->loader->load($this->configuration);
        }
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