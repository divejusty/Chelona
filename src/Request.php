<?php

namespace Chelona;

class Request
{
	public static function uri()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$uri = trim($uri, '/');
		return parse_url($uri, PHP_URL_PATH);
	}

	public static function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public static function all()
	{
		return $_SERVER;
	}
}
