<?php

namespace Chelona\Shell\Database;

use PDO;

/**
 * Undocumented class
 */
class DB
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private static $connection;

    /**
     * Undocumented function
     *
     * @param [type] $info
     *
     * @return void
     */
    public static function init($info)
    {
        try {
            static::$connection = new PDO(
                $info['type'].':host='. $info['host'] .':'.$info['port'].';dbname='.$info['dbname'],
                $info['username'],
                $info['password'],
                $info['options']
            );
        } catch (\Exception $e) {
            throw new DatabaseException('Could not connect to database.\n' . $e->getMessage());
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $table
     * @param [type] $model
     *
     * @return QueryBuilder
     */
    public static function table($table, $model = null)
    {
        return new QueryBuilder(static::$connection, $table, $model);
    }

}
