<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 16:11
 */

namespace Framework\Routing\Loader;


use Framework\Routing\RouteCollection;

class PhpFileLoader implements FileLoaderInterface
{

    /**
     * @param $path
     * @return RouteCollection
     * @throws \UnsupportedFileTypeException
     */
    public function load(string $path)
    {
        if('php' !== pathinfo($path, PATHINFO_EXTENSION)){
            throw new UnsupportedFileTypeException("File $path must be a PHP file.");
        }
        if(!is_readable($path)){
            throw new \InvalidArgumentException("File $path is not readable or not exists.");
        }
        $routes = include($path);
        if(!$routes instanceof RouteCollection){
            throw new \RuntimeException("File $path must return a RouteCollection instance.");
        }
        return $routes;
    }
}