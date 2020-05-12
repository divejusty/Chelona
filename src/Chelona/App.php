<?php

namespace Chelona;

/**
 * Storage class for app variables and constants
 */
class App
{
	/**
	 * The array in which the values are stored
	 *
	 * @var array
	 */
	private static $values = [];

	/**
	 * Binds values to our storage container.
	 *
	 * @param String $key
	 * @param String $value
	 *
	 * @return void
	 */
	public static function bind(String $key, String $value): void
	{
		static::$values[$key] = $value;
	}

	/**
	 * Gets a value from storage, based on the provided key.
	 * If the key doesn't exist, null is returned in stead
	 *
	 * @param String $key
	 *
	 * @return String|null
	 */
	public static function get(String $key)
	{
		if(isset(static::$values[$key])) {
			return static::$values[$key];
		}
		return null;
	}

	/**
	 * Check if a key is known.
	 *
	 * @param String $key
	 *
	 * @return boolean
	 */
	public static function has(String $key): bool
	{
		return isset(static::$values[$key]);
	}

	/**
	 * Removes a value from storage.
	 *
	 * @param String $key
	 *
	 * @return void
	 */
	public static function forget($key): void
	{
		unset(static::$values[$key]);
	}
}
