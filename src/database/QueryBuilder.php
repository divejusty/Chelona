<?php

namespace Chelona\Database;

use \PDO, \Exception;

class QueryBuilder
{
	private $connection;

	private $query;

	private $params = [];

	private $table;

	private $model;

	const OPERATORS = ['=', '==', '<', '>', '<=', '>='];
	const DIRECTIONS = [ 'ASC', 'DESC' ];

	public function __construct($connection, $table, $model = null)
	{
		$this->table = $table;

		$this->model = $model;

		try {
			$this->connection = $connection;

			$this->query = "SELECT * FROM {$table}";
		} catch(Exception $e) {
			throw new DatabaseException('Something went wrong.' . $e->getMessage());
		}
	}

	public function all()
	{
		return $this->execute();
	}

	public function find($key, $table = 'id')
	{
		return $this->where($table, '=', $key)->first();
	}

	public function where($column, $operator, $value)
	{
		if(!in_array($operator, static::OPERATORS)) {
			throw new DatabaseException('Unkown operator ' . $operator);
		}

		$this->query = $this->query . " WHERE {$this->table}.{$column} {$operator} :{$column}";
		$this->params[$column] = $value;

		return $this;
	}

	public function first()
	{
		$this->query = $this->query . ' LIMIT 1';

		$res = $this->execute();

		if(isset($res) && !empty($res)) {
			//return new $this->model
			return $res[0];
		}
		return null;
	}

	/**
	 * Performs a left join on another table
	 *
	 * @param [string] $table The table to be joined
	 * @param [any] $lkey The local key
	 * @param [any] $fkey The foreign key
	 *
	 * @return void
	 */
	public function with($table, $lkey, $fkey)
	{
		$this->query = $this->query . " LEFT JOIN {$table} ON {$this->table}.{$lkey} = {$table}.{$fkey}";

		return $this;
	}

	public function order($column, $direction = 'ASC')
	{
		if(!in_array($direction, static::DIRECTIONS)) {
			throw new DatabaseException('Unkown direction ' . $direction);
		}

		$this->query = $this->query . " ORDER BY {$this->table}.{$column} {$direction}";

		return $this;
	}

	private function execute()
	{
		try {
			$statement = $this->connection->prepare($this->query);
	
			$statement->execute($this->params);
			
			return $statement->fetchAll(PDO::FETCH_OBJ);

		} catch(Exception $e) {
			throw new DatabaseException('Could not execute query: ' . $this->query . '\n' . $e->getMessage());
		}
	}
}
