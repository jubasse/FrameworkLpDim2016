<?php

namespace Framework\Templating;
interface RendererInterface
{
    /**
     * @param $view
     * @param array $params
     *
     * @return string
     */
    public function render(string $view,array $params = []);
}