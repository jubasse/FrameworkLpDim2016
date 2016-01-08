<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 13:52
 */

namespace Application\Controller;


use Framework\Http\RequestInterface;
use Framework\Templating\ResponseRendererInterface;

class HelloWorldController
{
    /**
     * @var ResponseRendererInterface
     */
    private $renderer;

    public function setRenderer(ResponseRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(RequestInterface $request)
    {
        //return $this->renderer->renderResponse("hello.php",[ 'name'=>'hugo' ]);
        return $this->renderer->renderResponse('hello.tpl', [ 'name' => 'hugo' ]);
    }
}