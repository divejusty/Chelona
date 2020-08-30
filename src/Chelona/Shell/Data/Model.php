<?php

namespace Chelona\Shell\Data;

use \Chelona\Shell\Database\DB;

/**
 * Undocumented class
 */
abstract class Model
{
	// protected static $table = null; // TODO: set this auto-magically?
	/**
	 * Undocumented variable
	 *
	 * @var string
	 */
	protected static $primary = 'id';

	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	protected $data = null;

	/**
	 * Undocumented function
	 *
	 * @param array $data
	 */
	public function __construct($data = [])
	{
		$this->data = $data;
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	private static function getTable()
	{
		$class = explode('\\', static::class);
		return strtolower(end($class)) . 's';
	}

	/**
	 * Undocumented function
	 *
	 * @param mixed $key
	 *
	 * @return Model
	 */
	public static function find($key): Model
	{
		return new static(DB::table(static::getTable(), static::class)->find($key, static::$primary));
	}

	/**
	 * Undocumented function
	 *
	 * @return mixed
	 */
	public static function all()
	{
		return DB::table(static::getTable())->all();
	}

	/**
	 * Undocumented function
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		return 'hello?'; // TODO: Fix?
	}
}
