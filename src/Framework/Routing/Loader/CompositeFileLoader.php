<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 16:53
 */

namespace Framework\Routing\Loader;


class CompositeFileLoader implements FileLoaderInterface
{
    private $loaders;

    /**
     * CompositeFileLoader constructor.
     */
    public function __construct()
    {
        $this->loaders = [];
    }

    /**
     * @param FileLoaderInterface $loader
     */
    public function add(FileLoaderInterface $loader)
    {
        if(!in_array($loader, $this->loaders)){
            $this->loaders[] = $loader;
        }
    }

    /**
     * @param $path
     * @return RouteCollection
     */
    public function load($path)
    {
        foreach($this->loaders as $loader){
            if($routes = $this->tryLoadFile($loader,$path)){
                return $routes;
            }
        }
        throw new UnsupportedFileTypeException("No compatible loader found for file $path");
    }

    private function tryLoadFile(FileLoaderInterface $loader,string $path)
    {
        try{
            return $loader->load($path);
        }catch (UnsupportedFileTypeException $e){

        }
    }
}