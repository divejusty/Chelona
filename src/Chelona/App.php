<?php

//TODO Check if this is still useful and stuff, maybe just replace it with a Container? Or look into replacing it with a .env or smth

namespace Chelona;

/**
 * Storage class for app variables and constants
 */
class App
{
    /**
     * The array in which the values are stored
     *
     * @var array
     */
    private static $values = [];

    /**
     * Binds values to our storage container.
     *
     * @param String $key
     * @param mixed $value
     *
     * @return void
     */
    public static function bind(string $key, $value): void
    {
        static::$values[$key] = $value;
    }

    /**
     * Gets a value from storage, based on the provided key.
     * If the key doesn't exist, null is returned in stead
     *
     * @param String $key
     *
     * @return Mixed|null
     */
    public static function get(string $key)
    {
        if (isset(static::$values[$key])) {
            return static::$values[$key];
        }
        return null;
    }

    /**
     * Check if a key is known.
     *
     * @param String $key
     *
     * @return bool
     */
    public static function has(string $key): bool
    {
        return isset(static::$values[$key]);
    }

    /**
     * Removes a value from storage.
     *
     * @param String $key
     *
     * @return void
     */
    public static function forget($key): void
    {
        unset(static::$values[$key]);
    }
}
