<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/01/2016
 * Time: 13:54
 */

namespace Framework;


use Framework\Templating\ResponseRendererInterface;

abstract class AbstractController
{
    /**
     * @var ResponseRendererInterface
     */
    private $renderer;

    /**
     * @param ResponseRendererInterface $renderer
     */
    public function setRenderer(ResponseRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param $view
     * @param array $params
     * @return mixed
     */
    protected function render($view,array $params)
    {
        return $this->renderer->renderResponse($view,$params);
    }
}