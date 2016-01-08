<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 08/01/2016
 * Time: 09:53
 */

namespace Tests\Framework\Http;


use Framework\ControllerFactory;

class ControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testCreateControlleClassIsNotExists()
    {
        $factory = new ControllerFactory();
        $factory->createController(["_controller" => "FOOOOOOOOOOOOO"]);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCreateControllerNameIsNotDefined()
    {
        $factory = new ControllerFactory();
        $this->assertSame(FooBar::class,$factory->createController([]));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCreateNotInvokableController()
    {
        $factory = new ControllerFactory();
        $factory->createController(["_controller" => \stdClass::class]);
    }

    public function testCreateController()
    {
        $factory = new ControllerFactory();
        $this->assertInstanceOf(FooBar::class,$factory->createController(["_controller" => FooBar::class]));
    }
}

class FooBar
{
    public function __invoke()
    {
    }
}