<?php
namespace Tests\Framework\Http;
use Framework\Http\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideValidHttpMethod
     * @param $method
     * @param $path
     * @param $http
     */
    public function testCreateRequestInstance($method,$path,$http)
    {
        $request = new Request($method,$path,$http,"1.1");
        $this->assertSame($method,$request->getMethod(),"Assert of request method");
        $this->assertSame($path,$request->getPath(),"Assert of path");
        $this->assertSame($http,$request->getScheme(),"Assert of scheme");
        $this->assertSame("1.1",$request->getSchemeVersion(),"Assert of scheme version");
        $this->assertEmpty($request->getHeaders(),"Assert of headers");
        $this->assertEmpty($request->getBody(),"Assert of body");
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider provideInvalidHttpMethod
     * @param $method
     */
    public function testUnsupportedHttpMethod($method)
    {
        new Request($method,"/",Request::HTTP,"1.1");
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider provideInvalidHttpScheme
     * @param $scheme
     */
    public function testUnsupportedHttpScheme($scheme)
    {
        new Request("GET","/",$scheme,"1.1");
    }

    /**
     * @dataProvider provideValidHttpScheme
     * @param $scheme
     */
    public function testSupportedHttpScheme($scheme)
    {
        new Request("GET","/",$scheme,"1.1");
    }

    public function provideInvalidHttpScheme(){
        return [
            ["SSH"],
            ["FTP"],
            ["SMTP"],
            ["POP3"],
            ["SFTP"],
        ];
    }

    public function provideValidHttpScheme(){
        return [
            [Request::HTTP],
            [Request::HTTPS],
        ];
    }

    public function provideInvalidHttpMethod()
    {
        return [
            ['Foo'],
            ['Bar'],
            ['PURGE'],
            ['TOTO']
        ];
    }

    public function provideValidHttpMethod()
    {
        return [
            [ Request::METHOD_HEAD    , "/"     ,  "HTTP"   ],
            [ Request::METHOD_GET     , "/ho"   ,  "HTTPS"  ],
            [ Request::METHOD_POST    , "/foo"  ,  "HTTP"   ],
            [ Request::METHOD_PUT     , "/bar"  ,  "HTTP"   ],
            [ Request::METHOD_CONNECT , "/lol"  ,  "HTTPS"  ],
            [ Request::METHOD_OPTIONS , "/lola" ,  "HTTPS"  ],
            [ Request::METHOD_DELETE  , "/yt"   ,  "HTTP"   ],
            [ Request::METHOD_TRACE   , "/oii"  ,  "HTTP"   ],
            [ Request::METHOD_PATCH   , "/fgh"  ,  "HTTP"   ],
        ];
    }

    public function testUnsupportedHttpMethodBar()
    {
        $this->setExpectedException("InvalidArgumentException");
        new Request("Bar","/",Request::HTTP,"1.1");
    }
}
