<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 14:14
 */

namespace Framework\Routing;


interface RouterInterface
{
    /**
     * @param $path
     * @return array
     */
    public function match(string $path);
}