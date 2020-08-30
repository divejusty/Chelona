<?php

namespace Chelona\Shell\Http;

/**
 * Wrapper class for using request data.
 */
class Request
{
	const HTTP_GET = 'GET';
	const HTTP_HEAD = 'HEAD';
	const HTTP_POST = 'POST';
	const HTTP_PUT = 'PUT';
	const HTTP_PATCH = 'PATCH';
	const HTTP_DELETE = 'DELETE';

	const HTTP_METHODS = [
		static::HTTP_GET,
		static::HTTP_HEAD,
		static::HTTP_POST,
		static::HTTP_PUT,
		static::HTTP_PATCH,
		static::HTTP_DELETE,
	];

	/**
	 * Get the current URI.
	 *
	 * @return string
	 */
	public static function uri(): string
	{
		$uri = $_SERVER['REQUEST_URI'];
		$uri = trim($uri, '/');
		return parse_url($uri, PHP_URL_PATH);
	}

	/**
	 * Get the current request method. Unsupported methods such as PUT/DELETE/etc. can be specified with post data with _method.
	 *
	 * @return string
	 */
	public static function method(): string
	{
		// Check if there is something specified in the post data for _method
		$method = static::post('_method');

		if(!is_null($method) && in_array($method, self::HTTP_METHODS)) {
			return $method;
		}
		
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Returns all request data
	 *
	 * @return array
	 */
	public static function all(): array
	{
		return $_SERVER;
	}

	/**
	 * Retrieve POST data. Either retrieves a specific value by the specified key or retrieves all POST data.
	 * 
	 * @param string|null $key The optional key for retrieving post data
	 * 
	 * @return string|array|null
	 */
	public static function post(?string $key = null)
	{
		if(!is_null($key)) {
			if(isset($_POST[$key])) {
				return \htmlspecialchars($_POST[$key]);
			} else {
				return null;
			}
		}

		return array_map(function($item) {
			return \htmlspecialchars($item);
		}, $_POST);
	}
}
