<?php

declare(strict_types=1);

namespace Tests\Routing;

use Chelona\Shell\Http\RequestMethod;
use Chelona\Shell\Routing\Action;
use Chelona\Shell\Routing\Route;
use PHPUnit\Framework\TestCase;

final class RouteTest extends TestCase
{
    protected Action $defaultAction;
    protected string $defaultPath = '/foo';

    public function setUp(): void
    {
        parent::setUp();
        $this->defaultAction = new Action('FooController', 'index');
    }

	public function testGet()
	{
		$route = Route::get($this->defaultPath, $this->defaultAction);
        $this->assertTrue($route->isMethod(RequestMethod::GET));
        $this->assertEquals($this->defaultPath, $route->getPath());
	}

    public function testPost()
    {
        $route = Route::post($this->defaultPath, $this->defaultAction);
        $this->assertTrue($route->isMethod(RequestMethod::POST));
        $this->assertEquals($this->defaultPath, $route->getPath());
    }

    public function testPut()
    {
        $route = Route::put($this->defaultPath, $this->defaultAction);
        $this->assertTrue($route->isMethod(RequestMethod::PUT));
        $this->assertEquals($this->defaultPath, $route->getPath());
    }

    public function testDelete()
    {
        $route = Route::delete($this->defaultPath, $this->defaultAction);
        $this->assertTrue($route->isMethod(RequestMethod::DELETE));
        $this->assertEquals($this->defaultPath, $route->getPath());
    }

    public function testPatch()
    {
        $route = Route::patch($this->defaultPath, $this->defaultAction);
        $this->assertTrue($route->isMethod(RequestMethod::PATCH));
        $this->assertEquals($this->defaultPath, $route->getPath());
    }

    public function testParameters()
    {
        $path = '/foo/{id}';
        $route = Route::get($path, $this->defaultAction);
        $this->assertEquals($path, $route->getPath());
        $this->assertCount(1, $route->getParameters());
        $this->assertEquals('{id}', $route->getParameters()[2]);
    }
}
