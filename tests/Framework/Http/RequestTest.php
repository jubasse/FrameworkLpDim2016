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
        $request = new Request($method,$path,$http,"1.1",[
            "Host" => "http://www.google.com",
            "Content-Type" => "text/html",
            "Accept" => "application/json",
        ]);
        $this->assertSame($method,$request->getMethod(),"Assert of request method");
        $this->assertSame($path,$request->getPath(),"Assert of path");
        $this->assertSame($http,$request->getScheme(),"Assert of scheme");
        $this->assertSame("1.1",$request->getSchemeVersion(),"Assert of scheme version");
        $this->assertCount(3,$request->getHeaders());
        $this->assertSame([
            "host" => "http://www.google.com",
            "content-type" => "text/html",
            "accept" => "application/json",
        ],$request->getHeaders());
        $this->assertSame("http://www.google.com",$request->getHeader("Host"));
        $this->assertSame("application/json",$request->getHeader("Accept"));
        $this->assertSame("text/html",$request->getHeader("Content-Type"));
        $this->assertEmpty($request->getBody(),"Assert of body");
    }

    /**
     * @expectedException \RuntimeException
     * @dataProvider provideInvalidHttpHeaders
     */
    public function testAddSameHttpHeaderTwice()
    {
        $headers = [
            "Content-Type" => "text/html",
            "CONTENT-TYPE" => "application/json",
            "CONTENT-TYpe" => "application/text",
        ];

        new Request("GET","/","HTTP","1.1",$headers);
    }

    public function provideInvalidHttpHeaders()
    {
        return [
            [
                [
                    "Content-Type" => "text/html",
                    "CONTENT-TYPE" => "application/json",
                    "CONTENT-TYpe" => "application/text",
                ]
            ],[
                [
                    "Accept" => "text/html",
                    "CONTENT-TYPE" => "application/json",
                    "CONTENT-TYpe" => "application/text",
                ]
            ],
        ];
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
            [ "SSH"  ],
            [ "FTP"  ],
            [ "SMTP" ],
            [ "POP3" ],
            [ "SFTP" ],
        ];
    }

    public function provideValidHttpScheme(){
        return [
            [ Request::HTTP  ],
            [ Request::HTTPS ],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider provideInvalidHttpSchemeVersion
     * @param $schemeVersion
     */
    public function testUnsupportedHttpSchemeVersion($schemeVersion)
    {
        new Request("GET","/","HTTP",$schemeVersion);
    }

    /**
     * @dataProvider provideValidHttpSchemeVersion
     * @param $schemeVersion
     */
    public function testSupportedHttpSchemeVersion($schemeVersion)
    {
        new Request("GET","/","HTTP",$schemeVersion);
    }

    public function provideInvalidHttpSchemeVersion(){
        return [
            [ "1.3"     ],
            [ "3.4"     ],
            [ "7.0.0.1" ],
            [ "8.3"     ],
            [ "9.4"     ],
        ];
    }

    public function provideValidHttpSchemeVersion(){
        return [
            [ Request::VERSION_1_0 ],
            [ Request::VERSION_1_1 ],
            [ Request::VERSION_2_0 ],
        ];
    }

    public function provideInvalidHttpMethod()
    {
        return [
            [ 'Foo'   ],
            [ 'Bar'   ],
            [ 'PURGE' ],
            [ 'TOTO'  ],
        ];
    }

    public function provideValidHttpMethod()
    {
        return [
            [ Request::METHOD_HEAD    , "/"     ,  "HTTP"  ],
            [ Request::METHOD_GET     , "/ho"   ,  "HTTPS" ],
            [ Request::METHOD_POST    , "/foo"  ,  "HTTP"  ],
            [ Request::METHOD_PUT     , "/bar"  ,  "HTTP"  ],
            [ Request::METHOD_CONNECT , "/lol"  ,  "HTTPS" ],
            [ Request::METHOD_OPTIONS , "/lola" ,  "HTTPS" ],
            [ Request::METHOD_DELETE  , "/yt"   ,  "HTTP"  ],
            [ Request::METHOD_TRACE   , "/oii"  ,  "HTTP"  ],
            [ Request::METHOD_PATCH   , "/fgh"  ,  "HTTP"  ],
        ];
    }

    public function testUnsupportedHttpMethodBar()
    {
        $this->setExpectedException("InvalidArgumentException");
        new Request("Bar","/",Request::HTTP,"1.1");
    }
}
