<?php

namespace Chelona\Routing;

use Chelona\Request;

class Router
{
	/**
	 * The collection of all registered routes in the application
	 */
	private static $routes = [];

	/**
	 * The base URL for the application. Will be prepended to all paths.
	 */
	private static $base;

	/**
	 * The namespace in which the endpoints reside.
	 */
	private static $endpointPath;

	/**
	 * Initialize the router.
	 * 
	 * @param $base Will be used to set the base URL for the application. Defaults to an empty string.
	 * @param $endpointPath Will be used to set the namespace for the application. Defaults to an empty string.
	 */
	public static function init($base = '', $endpointPath = '')
	{
		static::$base 			= $base;
		static::$endpointPath 	= $endpointPath;
	}

	/**
	 * Adds a route to the collection of routes.
	 * @param $base ...
	 * @param Chelona\Routing\Route $route ...
	 */
	public static function add($uri, Route $route)
	{

		static::$routes[$uri] = $route;
	}

	public static function direct()
	{
		$uri = Request::uri();
		$uri = str_replace(static::$base, '', $uri);
		$method = Request::method();
		$matchUri = '{' . $uri . '}'; // Do this so we can match the whole thing
		foreach(static::$routes as $path => $route) {
			if(preg_match_all($path, $matchUri) && $route->isMethod($method)) {
				return $route->call(static::$endpointPath, $uri);
			}
		}

		throw new RouterException('Route ' . static::$base . $uri . ' is not defined');
	}
}
