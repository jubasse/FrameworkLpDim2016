<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 13:52
 */

namespace Application\Controller;


use Framework\Http\RequestInterface;
use Framework\Http\Response;

class HelloWorldController
{
    public function __invoke(RequestInterface $request)
    {
        return new Response(
            Response::HTTP_OK,
            $request->getScheme(),
            $request->getSchemeVersion(),
            ["Content-Type"=>"application/json"],
            json_encode(["hello" => "world"])
        );
    }
}