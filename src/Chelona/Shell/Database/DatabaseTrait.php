<?php

namespace Chelona\Shell\Database;

/**
 * Trait that handles some generic database stuff.
 * 
 * TODO: Think of a good naming scheme / split some stuff out?
 */
trait DatabaseTrait
{
	const OPERATORS = ['=', '==', '<', '>', '<=', '>='];
	
	const DIRECTIONS = [ 'ASC', 'DESC' ];

	/**
	 * Executes the given query using the given connection.
	 * 
	 * @param \PDO $connection
	 * @param string $query
	 * @param array $params
	 * 
	 * @return
	 * @throws DatabaseException
	 */
	protected static function executeQuery(\PDO $connection, string $query, $params = [])
	{
		try {
			$statement = $connection->prepare($query);
	
			if (!empty($params)) {
				$statement->execute($params);
			}
			
			return $statement->fetchAll(\PDO::FETCH_OBJ);

		} catch(\Exception $e) {
			throw new DatabaseException('Could not execute query: ' . $query . '\n' . $e->getMessage());
		}
	}
}
