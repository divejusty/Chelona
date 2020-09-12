<?php

namespace Chelona\Shell\Database;

/**
 * Undocumented class
 */
class QueryBuilder
{
	use DatabaseTrait;

	/**
	 * The Database connection
	 */
	private \PDO $connection;

	/**
	 * Undocumented variable
	 */
	private string $query;

	/**
	 * Array to store parameters
	 */
	private array $params = [];

	/**
	 * Undocumented variable
	 */
	private string $table;

	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $model;

	/**
	 * Undocumented function
	 *
	 * @param \PDO $connection
	 * @param string $table
	 * @param mixed|null $model
	 */
	public function __construct(\PDO $connection, string $table, $model = null)
	{
		$this->table = $table;
		$this->model = $model;

		try {
			$this->connection = $connection;

			$this->query = "SELECT * FROM {$table}";
		} catch(\Exception $e) {
			throw new DatabaseException('Something went wrong.' . $e->getMessage());
		}
	}

	/**
	 * Retrieve all results
	 *
	 * @return mixed
	 */
	public function all()
	{
		return $this->execute();
	}

	/**
	 * Undocumented function
	 *
	 * @param mixed $key
	 * @param string $column 
	 *
	 * @return QueryBuilder
	 */
	public function find($key, string $column = 'id'): QueryBuilder
	{
		return $this->where($column, '=', $key)->first();
	}

	/**
	 * Undocumented function
	 *
	 * @param string $column
	 * @param string $operator
	 * @param mixed $value
	 *
	 * @return QueryBuilder
	 */
	public function where(string $column, string $operator, $value): QueryBuilder
	{
		if(!in_array($operator, static::OPERATORS)) {
			throw new DatabaseException('Unkown operator ' . $operator);
		}

		$this->query = $this->query . " WHERE {$this->table}.{$column} {$operator} :{$column}";
		$this->params[$column] = $value;

		return $this;
	}

	/**
	 * Retrieve the first result
	 *
	 * @return QueryBuilder|null
	 */
	public function first(): ?QueryBuilder
	{
		$this->query .= ' LIMIT 1';

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
	 * @param string $table The table to be joined
	 * @param string $lkey The local key
	 * @param string $fkey The foreign key
	 *
	 * @return QueryBuilder
	 */
	public function with(string $table, string $lkey, string $fkey): QueryBuilder
	{
		$this->query = $this->query . " LEFT JOIN {$table} ON {$this->table}.{$lkey} = {$table}.{$fkey}";

		return $this;
	}

	/**
	 * Set ordering options
	 *
	 * @param string $column
	 * @param string $direction
	 *
	 * @return QueryBuilder
	 */
	public function order(string $column, string $direction = 'ASC'): QueryBuilder
	{
		if(!in_array($direction, static::DIRECTIONS)) {
			throw new DatabaseException('Unkown direction ' . $direction);
		}

		$this->query = $this->query . " ORDER BY {$this->table}.{$column} {$direction}";

		return $this;
	}

	/**
	 * Executes the query
	 *
	 * @return mixed
	 * @throws DatabaseException
	 */
	private function execute()
	{
		return static::executeQuery($this->connection, $this->query, $this->params);
	}
}
