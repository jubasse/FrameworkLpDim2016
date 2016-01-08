<?php

namespace Framework\Templating;
use Framework\Http\Response;
use Framework\Http\ResponseInterface;

interface ResponseRendererInterface extends RendererInterface
{
    /**
     * @param $view
     * @param array $params
     * @param int $statusCode
     * @return Response
     */
    public function renderResponse(string $view,array $params = [],$statusCode = ResponseInterface::HTTP_OK);
}