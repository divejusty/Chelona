<?php

namespace Chelona;

use \Chelona\Database\DB;

abstract class Model
{
	// protected static $table = null; // TODO: set this auto-magically?
	protected static $primary = 'id';

	protected $data = null;

	public function __construct($data = [])
	{
		$this->data = $data;
	}
	
	private static function getTable()
	{
		$class = explode('\\', static::class);
		return strtolower(end($class)) . 's';
	}

	public static function find($key)
	{
		return new static(DB::table(static::getTable(), static::class)->find($key, static::$primary));
	}

	public static function all()
	{
		return DB::table(static::getTable())->all();
	}

	public function __toString()
	{
		return 'hello?'; // TODO: Fix?
	}
}
