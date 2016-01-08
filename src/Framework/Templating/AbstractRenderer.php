<?php

namespace Framework\Templating;

use Framework\Http\Response;
use Framework\Http\ResponseInterface;

abstract class AbstractRenderer implements ResponseRendererInterface
{
    private $directory;

    /**
     * @param $directory
     */
    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            throw new \InvalidArgumentException(sprintf('Directory "%s" does not exist.', $directory));
        }

        $this->directory = realpath($directory);
    }

    /**
     * @param $view
     * @return string
     */
    protected function getTemplatePath(string $view)
    {
        $path = $this->directory.DIRECTORY_SEPARATOR.$view;
        if (!is_readable($path)) {
            throw new TemplateNotFoundException(sprintf(
                'Template "%s" cannot be found in "%s" directory.',
                $view,
                $this->directory
            ));
        }

        return $path;
    }

    /**
     * Evaluates a template view file and returns a Response instance.
     *
     * @param $view
     * @param array  $params The view variables
     * @param int    $statusCode The response status code
     *
     * @return Response
     */
    public function renderResponse(string $view, array $params = [], $statusCode = ResponseInterface::HTTP_OK)
    {
        return new Response($statusCode, 'HTTP', '1.1', [], $this->render($view, $params));
    }
}