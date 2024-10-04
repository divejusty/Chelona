<?php

namespace Chelona\Shell\Database;

use PDO;
use Exception;

/**
 * Undocumented class
 */
class QueryBuilder
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $connection;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $query;

    /**
     * Undocumented variable
     *
     * @var array
     */
    private $params = [];

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $table;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $model;

    /**
     *
     */
    public const OPERATORS = ['=', '==', '<', '>', '<=', '>='];

    /**
     *
     */
    public const DIRECTIONS = [ 'ASC', 'DESC' ];

    /**
     * Undocumented function
     *
     * @param [type] $connection
     * @param [type] $table
     * @param [type] $model
     */
    public function __construct($connection, $table, $model = null)
    {
        $this->table = $table;
        $this->model = $model;

        try {
            $this->connection = $connection;

            $this->query = "SELECT * FROM {$table}";
        } catch (Exception $e) {
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
     * @param [type] $key
     * @param string $table
     *
     * @return QueryBuilder
     */
    public function find($key, $table = 'id'): QueryBuilder
    {
        return $this->where($table, '=', $key)->first();
    }

    /**
     * Undocumented function
     *
     * @param [type] $column
     * @param [type] $operator
     * @param [type] $value
     *
     * @return QueryBuilder
     */
    public function where($column, $operator, $value): QueryBuilder
    {
        if (!in_array($operator, static::OPERATORS)) {
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
    public function first()
    {
        $this->query .= ' LIMIT 1';

        $res = $this->execute();

        if (isset($res) && !empty($res)) {
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
     * @return QueryBuilder
     */
    public function with($table, $lkey, $fkey): QueryBuilder
    {
        $this->query = $this->query . " LEFT JOIN {$table} ON {$this->table}.{$lkey} = {$table}.{$fkey}";

        return $this;
    }

    /**
     * Set ordering options
     *
     * @param [type] $column
     * @param string $direction
     *
     * @return QueryBuilder
     */
    public function order($column, $direction = 'ASC'): QueryBuilder
    {
        if (!in_array($direction, static::DIRECTIONS)) {
            throw new DatabaseException('Unkown direction ' . $direction);
        }

        $this->query = $this->query . " ORDER BY {$this->table}.{$column} {$direction}";

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    private function execute()
    {
        try {
            $statement = $this->connection->prepare($this->query);

            $statement->execute($this->params);

            return $statement->fetchAll(PDO::FETCH_OBJ);

        } catch (Exception $e) {
            throw new DatabaseException('Could not execute query: ' . $this->query . '\n' . $e->getMessage());
        }
    }
}
