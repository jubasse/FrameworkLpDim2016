<?php
namespace Framework;
use Framework\Http\ResponseInterface;
use Framework\Http\RequestInterface;
interface KernelInterface
{
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request);
}