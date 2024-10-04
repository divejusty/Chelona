<?php

namespace Chelona\Shell\Database;

use PDO;
use PDOException;

final class DB
{
    private static PDO $connection;

    /**
     * @throws \Chelona\Shell\Database\DatabaseException
     */
    public static function init(array $info): void
    {
        try {
            DB::$connection = new PDO(
                $info['type'].':host='. $info['host'] .':'.$info['port'].';dbname='.$info['dbname'],
                $info['username'],
                $info['password'],
                $info['options']
            );
        } catch (PDOException $e) {
            throw new DatabaseException('Could not connect to database.\n' . $e->getMessage(), 500, $e);
        }
    }

    /**
     * @throws \Chelona\Shell\Database\DatabaseException
     */
    public static function table(string $table, $model = null): QueryBuilder
    {
        return new QueryBuilder(DB::$connection, $table, $model);
    }

}
