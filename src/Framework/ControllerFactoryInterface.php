<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/01/2016
 * Time: 09:42
 */

namespace Framework;


interface ControllerFactoryInterface
{
    /**
     * @param array $params
     * @return Callable
     */
    public function createController(array $params);
}