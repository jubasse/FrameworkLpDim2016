<?php

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateRequestInstance()
    {
        $request = new Request(Request::METHOD_GET,"/",Request::HTTP,"1.1");
        $this->assertSame(Request::METHOD_GET,$request->getMethod(),"Assert of request method");
        $this->assertSame("/",$request->getPath(),"Assert of path");
        $this->assertSame(Request::HTTP,$request->getScheme(),"Assert of scheme");
        $this->assertSame("1.1",$request->getSchemeVersion(),"Assert of scheme version");
        $this->assertEmpty($request->getHeaders(),"Assert of headers");
        $this->assertEmpty($request->getBody(),"Assert of body");
    }
}
