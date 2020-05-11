<?php

namespace Chelona;

class Request
{
	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public static function uri()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$uri = trim($uri, '/');
		return parse_url($uri, PHP_URL_PATH);
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public static function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public static function all()
	{
		return $_SERVER;
	}
}
