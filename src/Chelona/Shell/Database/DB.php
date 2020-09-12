<?php

namespace Chelona\Shell\Database;

/**
 * This class handles basic database interactions.
 */
class DB
{
	use DatabaseTrait;

	/**
	 * Field where the connection is stored.
	 */
	private static \PDO $connection;

	/**
	 * Sets up the database connection and stores it.
	 *
	 * @param array $info
	 *
	 * @return void
	 * @throws DatabaseException
	 */
	public static function init(array $info): void
	{
		try { 
			static::$connection = new \PDO(
				$info['type'].':host='. $info['host'] .':'.$info['port'].';dbname='.$info['dbname'],
				$info['username'],
				$info['password'],
				$info['options']
			);
		} catch(\Exception $e) {
			throw new DatabaseException('Could not connect to database.\n' . $e->getMessage());
		}
	}

	/**
	 * Creates a querybuilder instance for the given table.
	 *
	 * @param string $table
	 * @param mixed|null $model
	 *
	 * @return QueryBuilder
	 */
	public static function table(string $table, $model = null): QueryBuilder
	{
		return new QueryBuilder(static::$connection, $table, $model);
	}

	/**
	 * Takes a raw SQL query and executes it.
	 * 
	 * @param string $query The query to be executed.
	 * 
	 * @return array
	 * 
	 */
	public static function raw(string $query): array
	{
		return static::executeQuery(static::$connection, $query);
	}

}
