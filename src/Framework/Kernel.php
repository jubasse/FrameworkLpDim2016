<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 10:42
 */

namespace Framework;

use Framework\Http\Request;
use Framework\Http\RequestInterface;
use Framework\Http\Response;
use Framework\Http\ResponseInterface;

class Kernel implements KernelInterface
{
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        return new Response(
            Request::HTTP_OK,
            $request->getScheme(),
            $request->getSchemeVersion(),
            ['Content-Type'=>"application/json"],
            json_encode(["hello"=>"world"])
        );
    }
}