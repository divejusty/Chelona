<?php

namespace Chelona\Shell\Routing;

use Chelona\Shell\Http\Request;

/**
 * Defines the Route object used in routing for http requests
 */
class Route
{
	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $path;
	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $endpoint;
	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $action;
	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $method;
	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	private $params = [];

	/**
	 * Undocumented function
	 *
	 * @param [type] $path
	 * @param [type] $endpoint
	 * @param [type] $action
	 * @param [type] $method
	 */
	private function __construct($path, $endpoint, $action, $method)
	{
		
		$this->endpoint = $endpoint;
		$this->action 	= $action;
		$this->method 	= $method;
		$this->path 	= $path;

		$params = [];
		preg_match_all('/(\{[A-z]*\})/', $path, $params);

		if(count($params[0]) > 0) {
			$pathParts = explode('/', $this->path);
			foreach($pathParts as $pos => $part) {
				if(in_array($part, $params[0])) {
					$this->params[$pos] = $part;
				}
			}
		}
	}

	/**
	 * Parses a route
	 *
	 * @param string $path
	 * @return string
	 */
	private static function parseRoute(string $path): string
	{
		$path = preg_replace('/(\{[A-z]*\})/', '(([A-z]|[0-9])+)', $path);
		$path = str_replace('/', '\/', $path);
		return '/\{' . $path . '\}/';
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $endpointPath
	 * @return object
	 */
	private function getEndpoint($endpointPath)
	{
		$endpoint = '\\' . $endpointPath . '\\'. $this->endpoint;
		return (new $endpoint());
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $uri
	 * @return array
	 */
	private function extractParams($uri)
	{
		$params = [];
		$uriParts = explode('/', $uri);
		foreach($this->params as $pos => $param) {
			$params[$pos] = $uriParts[$pos];
		}
		return $params;
	}

	/**
	 * Function used to create routes and add them to the router.
	 *
	 * @param string $path
	 * @param string $action
	 * @param string $method
	 *
	 * @return Route
	 */
	private static function createRoute(string $path, string $action, string $method): Route
	{
		$route = explode('@', $action);
		$route = new Route(
			$path,
			$route[0],
			$route[1],
			$method
		);
		Router::add(static::parseRoute($path), $route);

		return $route;
	}

	// Interface //

	/**
	 * Creates a route for a GET request.
	 *
	 * @param string $path
	 * @param string $endpoint
	 *
	 * @return Route
	 */
	public static function get(string $path, string $endpoint): Route
	{
		return static::createRoute($path, $endpoint, Request::HTTP_GET);
	}

	/**
	 * Creates a route for a POST request.
	 *
	 * @param string $path
	 * @param string $endpoint
	 *
	 * @return Route
	 */
	public static function post(string $path, string $endpoint): Route
	{
		return static::createRoute($path, $endpoint, Request::HTTP_POST);
	}

	/**
	 * Creates a route for a PUT request.
	 *
	 * @param string $path
	 * @param string $endpoint
	 *
	 * @return Route
	 */
	public static function put(string $path, string $endpoint): Route
	{
		return static::createRoute($path, $endpoint, Request::HTTP_PUT);
	}

	/**
	 * Creates a route for a PATCH request.
	 *
	 * @param string $path
	 * @param string $endpoint
	 *
	 * @return Route
	 */
	public static function patch(string $path, string $endpoint): Route
	{
		return static::createRoute($path, $endpoint, Request::HTTP_PATCH);
	}

	/**
	 * Creates a route for a DELETE request.
	 *
	 * @param string $path
	 * @param string $endpoint
	 *
	 * @return Route
	 */
	public static function delete(string $path, string $endpoint): Route
	{
		return static::createRoute($path, $endpoint, Request::HTTP_DELETE);
	}

	/**
	 * Returns the Route's path.
	 *
	 * @return void
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Calls the endpoint associated with the Route.
	 *
	 * @param [type] $endpointPath
	 * @param [type] $uri
	 * @return void
	 */
	public function call($endpointPath, $uri)
	{
		$class = $this->getEndpoint($endpointPath);
		if(! method_exists($class, $this->action)) {
			throw new RouterException('Undefined method `' . $this->action . '` in endpoint `' . $this->endpoint . '`.');
		}

		if(count($this->params) > 0) {
			$params = $this->extractParams($uri);
			return $class->{$this->action}(...$params);
		}

		return $class->{$this->action}();
	}

	/**
	 * Checks whether the provided method matches the method of this route.
	 *
	 * @param string $method
	 *
	 * @return bool
	 */
	public function isMethod(string $method): bool
	{
		return $this->method == $method;
	}

}
