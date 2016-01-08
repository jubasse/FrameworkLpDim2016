<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 13:52
 */

namespace Application\Controller;

use Framework\AbstractController;
use Framework\Http\RequestInterface;

class HelloWorldController extends AbstractController
{
    public function __invoke(RequestInterface $request)
    {
        //return $this->renderer->renderResponse("hello.php",[ 'name'=>'hugo' ]);
        //return $this->renderer->renderResponse('hello.tpl', [ 'name' => 'hugo' ]);
        return $this->render('hello.twig', [ 'name' => 'hugo' ]);
    }
}