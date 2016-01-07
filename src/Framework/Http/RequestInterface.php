<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 06/01/2016
 * Time: 16:50
 */

namespace Framework\Http;


interface RequestInterface extends MessageInterface
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_CONNECT = 'CONNECT';
    const METHOD_HEAD = 'HEAD';
    const METHOD_TRACE = 'TRACE';
    const METHOD_PATCH = 'PATCH';

    public function getPath();
    public function getMethod();
    public function send();
}