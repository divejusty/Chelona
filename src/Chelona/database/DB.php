<?php

namespace Chelona\Database;

use \PDO;

class DB
{
	private static $connection;

	public static function init($info)
	{
		try { 
			static::$connection = new PDO(
				$info['type'].':host='. $info['host'] .':'.$info['port'].';dbname='.$info['dbname'],
				$info['username'],
				$info['password'],
				$info['options']
			);
		} catch(\Exception $e) {
			throw new DatabaseException('Could not connect to database.\n' . $e->getMessage());
		}
	}

	public static function table($table, $model = null)
	{
		return new QueryBuilder(static::$connection, $table, $model);
	}

}
