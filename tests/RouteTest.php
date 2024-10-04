<?php

declare(strict_types=1);

namespace Tests;

use Chelona\Shell\Http\RequestMethod;
use PHPUnit\Framework\TestCase;

use \Chelona\Shell\Routing\Route;

final class RouteTest extends TestCase
{
	public function testGet()
	{
        $path = '/foo';
		$route = Route::get($path, 'FooController@index');
        $this->assertTrue($route->isMethod(RequestMethod::GET));
        $this->assertEquals($path, $route->getPath());
	}

    public function testPost()
    {
        $path = '/foo';
        $route = Route::post($path, 'FooController@index');
        $this->assertTrue($route->isMethod(RequestMethod::POST));
        $this->assertEquals($path, $route->getPath());
    }

    public function testPut()
    {
        $path = '/foo';
        $route = Route::put($path, 'FooController@index');
        $this->assertTrue($route->isMethod(RequestMethod::PUT));
        $this->assertEquals($path, $route->getPath());
    }

    public function testDelete()
    {
        $path = '/foo';
        $route = Route::delete($path, 'FooController@index');
        $this->assertTrue($route->isMethod(RequestMethod::DELETE));
        $this->assertEquals($path, $route->getPath());
    }

    public function testPatch()
    {
        $path = '/foo';
        $route = Route::patch($path, 'FooController@index');
        $this->assertTrue($route->isMethod(RequestMethod::PATCH));
        $this->assertEquals($path, $route->getPath());
    }
}
