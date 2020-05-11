<?php

namespace Chelona;

class App
{
	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	private static $values = [];

	/**
	 * Undocumented function
	 *
	 * @param [type] $key
	 * @param [type] $value
	 *
	 * @return void
	 */
	public static function bind($key, $value)
	{
		static::$values[$key] = $value;
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $key
	 *
	 * @return void
	 */
	public static function get($key)
	{
		if(isset(static::$values[$key])) {
			return static::$values[$key];
		}
		return null;
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $key
	 *
	 * @return boolean
	 */
	public static function has($key)
	{
		return isset(static::$values[$key]);
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $key
	 *
	 * @return void
	 */
	public static function forget($key)
	{
		unset(static::$values[$key]);
	}
}
