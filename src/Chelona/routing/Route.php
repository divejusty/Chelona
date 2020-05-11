<?php

namespace Chelona\Routing;

/**
 * Undocumented class
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
	public function __construct($path, $endpoint, $action, $method)
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
	 * Undocumented function
	 *
	 * @param [type] $path
	 * @param [type] $action
	 *
	 * @return void
	 */
	public static function get($path, $action)
	{
		return static::createRoute($path, $action, 'GET');
	}

	public static function post($path, $action)
	{
		return static::createRoute($path, $action, 'POST');
	}

	private static function createRoute($path, $action, $method)
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

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $path
	 * @return void
	 */
	private static function parseRoute($path)
	{
		$path = preg_replace('/(\{[A-z]*\})/', '(([A-z]|[0-9])+)', $path);
		$path = str_replace('/', '\/', $path);
		return '/\{' . $path . '\}/';
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $endpointPath
	 * @return void
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
	 * @return void
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
	 * Undocumented function
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
	 * Checks whether the provided method matches the method of this route
	 *
	 * @param string $method
	 *
	 * @return boolean
	 */
	public function isMethod($method)
	{
		return $this->method == $method;
	}

}
