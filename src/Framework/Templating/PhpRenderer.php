<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/01/2016
 * Time: 10:40
 */

namespace Framework\Templating;


use Framework\Http\Response;

class PhpRenderer extends AbstractRenderer
{
    private $directory;

    /**
     * PhpRenderer constructor.
     * @param $directory
     */
    public function __construct(string $directory)
    {
        if(!is_dir($directory)){
            throw new \InvalidArgumentException("Directory $directory does not exists.");
        }
        $this->directory = realpath($directory);
    }


    /**
     * @param $view
     * @param array $params
     *
     * @return string
     */
    public function render(string $view, array $params = [])
    {
        $path = $this->directory.DIRECTORY_SEPARATOR.$view;
        if(!is_readable($path)){
            throw new TemplateNotFoundException("Template $view cannot be found in {$this->directory}.");
        }
        if(in_array("view",$params)){
            throw new \RuntimeException("The 'View' template variable is a reserved keyword");
        }
        $params["view"] = $this;
        extract($params);
        ob_start();
        include $path;

        return ob_get_clean();
    }

    /**
     * @param $var
     * @return string
     */
    public function e(string $var)
    {
        return htmlspecialchars($var,ENT_QUOTES,"UTF-8");
    }

    /**
     * @param $view
     * @param array $params
     * @param int $statusCode
     * @return Response
     */
    public function renderResponse(string $view, array $params = [], $statusCode = Response::HTTP_OK)
    {
        return new Response(200,"HTTP",Response::VERSION_1_1,[],$this->render($view,$params));
    }
}