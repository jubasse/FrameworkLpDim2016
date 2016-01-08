<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/01/2016
 * Time: 12:01
 */

namespace Framework\Templating;


use Framework\Http\Response;
use Framework\Http\ResponseInterface;

class TwigRendererAdapter implements ResponseRendererInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $view
     * @param array $params
     *
     * @return string
     */
    public function render(string $view, array $params = [])
    {
        try {
            return $this->twig->render($view,$params);
        } catch(\Twig_Error_Loader $e){
            throw new TemplateNotFoundException("Template '$view' cannot be found by Twig",0,$e);
        }
    }

    /**
     * @param $view
     * @param array $params
     * @param int $statusCode
     * @return Response
     */
    public function renderResponse(string $view, array $params = [], $statusCode = ResponseInterface::HTTP_OK)
    {
        return new Response($statusCode, 'HTTP', '1.1', [], $this->render($view, $params));
    }
}