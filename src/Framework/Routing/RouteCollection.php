<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 14:26
 */

namespace Framework\Routing;

class RouteCollection implements \Iterator, \Countable
{
    private $routes;
    private $position;

    /**
     * RouteCollection constructor.
     */
    public function __construct()
    {
        $this->routes =[];
        $this->position = 0;
    }

    public function match(string $path)
    {
        foreach($this->routes as $route){
            if($route->match($path)){
                return $route;
            }
        }
    }

    /**
     * @param $name
     * @param Route $route
     * @param bool $override
     */
    public function add(string $name,Route $route, $override = false)
    {
        if(isset($this->routes[$name]) && !$override){
            throw new \InvalidArgumentException("A route already exists for the name $name");
        }
        $this->routes[$name] = $route;
    }

    public function count()
    {
        return count($this->routes);
    }

    public function merge(RouteCollection $routes, $override = false)
    {
        foreach($routes as $name => $route){
            $this->add($name,$routes,$override);
        }
    }
    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->routes);
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        return next($this->routes);
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->routes);
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return ($this->current() instanceof Route);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        return reset($this->routes);
    }
}