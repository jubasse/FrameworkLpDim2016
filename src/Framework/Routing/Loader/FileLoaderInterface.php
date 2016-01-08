<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 16:07
 */

namespace Framework\Routing\Loader;


interface FileLoaderInterface
{
    /**
     * @param $path
     * @return RouteCollection
     */
    public function load(string $path);
}