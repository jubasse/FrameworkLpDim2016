<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/01/2016
 * Time: 09:44
 */

namespace Framework;


class ControllerFactory implements ControllerFactoryInterface
{

    /**
     * @param array $params
     * @return Callable
     */
    public function createController(array $params)
    {
        if (empty($params['_controller'])) {
            throw new \RuntimeException("No router parameter found.");
        }

        $class = $params['_controller'];
        if (!class_exists($class)) {
            throw new \RuntimeException("Controller class \"$class\" does not exist or cannot be autoloaded.");
        }

        $action = new $class();
        if (!method_exists($action,"__invoke")) {
            throw new \RuntimeException('Controller is not a valid PHP callable object. Make sure the __invoke() method is implemented!');
        }

        return $action;
    }
}