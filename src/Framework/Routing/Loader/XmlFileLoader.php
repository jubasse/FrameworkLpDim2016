<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 16:10
 */

namespace Framework\Routing\Loader;


use Framework\Routing\Route;
use Framework\Routing\RouteCollection;

class XmlFileLoader implements FileLoaderInterface
{

    /**
     * @param $path
     * @return RouteCollection
     * @throws \UnsupportedFileTypeException
     */
    public function load($path)
    {
        if('xml' !== pathinfo($path, PATHINFO_EXTENSION)){
            throw new \UnsupportedFileTypeException("File $path must be a PHP file.");
        }
        if(!is_readable($path)){
            throw new \InvalidArgumentException("File $path is not readable or not exists.");
        }
        return $this->parseRoutes($path);
    }

    private function parseRoutes($path)
    {
        $routes = new RouteCollection();
        $xml = new \SimpleXMLElement(file_get_contents($path));
        foreach($xml->route as $route){
            $this->parseRoute($routes,$route);
        }
        return $routes;
    }

    private function parseRoute(RouteCollection $routes, \SimpleXMLElement $route)
    {
        if (empty($route["name"])){
            throw new \RuntimeException("Each route must have a unique name.");
        }
        if (empty($route["path"])){
            throw new \RuntimeException("Each route must have a path.");
        }

        $name = (string) $route["name"];
        $path = (string) $route["path"];

        $params = [];
        $params = $this->parseRouteParams($route, $name, $params);
        $routes->add($route["name"],new Route($path,$params));
    }

    /**
     * @param \SimpleXMLElement $route
     * @param $name
     * @param $params
     * @return mixed
     */
    private function parseRouteParams(\SimpleXMLElement $route, $name, $params)
    {
        if (count($route)) {
            foreach ($route->param as $i => $param) {
                $params = $this->parseRouteParam($name, $params, $param, $i);
            }
            return $params;
        }
        return $params;
    }

    /**
     * @param $name
     * @param $params
     * @param $param
     * @param $i
     * @return mixed
     */
    private function parseRouteParam($name, $params, $param, $i)
    {
        if (empty($param["key"])) {
            throw new \RuntimeException("Param $i for route $name must have a 'key' attribute");
        }
        $key = (string)$param["key"];
        $params[$key] = (string)$param;
        return $params;
    }
}