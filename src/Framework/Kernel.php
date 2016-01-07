<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07/01/2016
 * Time: 10:42
 */

namespace Framework;

use Framework\Http\RequestInterface;
use Framework\Http\Response;
use Framework\Http\ResponseInterface;
use Framework\Routing\RouterInterface;
use Framework\Routing\RouterNotFoundException;

class Kernel implements KernelInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        $response = null;

        try {
            $params = $this->router->match($request->getPath());
        } catch(RouterNotFoundException $e){
            $response = new Response(
                Response::HTTP_NOT_FOUND,
                $request->getScheme(),
                $request->getSchemeVersion(),
                [],
                "Page Not Found"
            );
        }
        if(!empty($params["_controller"])) {
            $action = new $params["_controller"]();
            $response = call_user_func_array($action, [$request]);
        }
        if(!$response instanceof ResponseInterface){
            throw new \RuntimeException('A response instance must be set.');
        }

        return $response;
    }
}