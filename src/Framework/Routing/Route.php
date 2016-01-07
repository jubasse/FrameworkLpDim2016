<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 14:23
 */

namespace Framework\Routing;


class Route
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var array
     */
    private $parameters;

    /**
     * Route constructor.
     * @param $path
     * @param $parameters
     */
    public function __construct(string $path,array $parameters = [])
    {
        $this->path = $path;
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param $path
     * @return bool
     */
    public function match(string $path)
    {
        return ($path === $this->path);
    }
}