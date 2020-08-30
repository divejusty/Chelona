<?php

namespace Chelona\Shell\Routing;

use Chelona\Shell\Http\Request;

/**
 * Undocumented class
 */
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
	 * 
	 * @return void
	 */
	public static function init($base = '', $endpointPath = ''): void
	{
		static::$base 			= $base;
		static::$endpointPath 	= $endpointPath;
	}

	/**
	 * Adds a route to the collection of routes.
	 * 
	 * @param $uri ...
	 * @param Chelona\Routing\Route $route ...
	 * 
	 * @return void
	 */
	public static function add($uri, Route $route): void
	{
		static::$routes[$uri] = $route;
	}

	/**
	 * Call the associated callable of the current URI. 
	 * Throw an exception if the method is incorrect or the route does not exist.
	 *
	 * @return void
	 */
	public static function direct()
	{
		// Prepare the URI
		$uri = Request::uri();
		$uri = str_replace(static::$base, '', $uri);
		$method = Request::method();
		$matchUri = '{' . $uri . '}'; // Do this so we can match the whole thing

		// Compare the URI with our routes
		foreach(static::$routes as $path => $route) {
			if(preg_match_all($path, $matchUri)) {
				if(!$route->isMethod($method)) {
					throw new RouterException("Incorrect method {$method} for route " . static::$base ."{$uri}!"); // Check if this works...
				}

				// If a result is found, call the associated thing
				return $route->call(static::$endpointPath, $uri);
			}
		}

		throw new RouterException('Route ' . static::$base ."{$uri} is not defined");
	}
}
