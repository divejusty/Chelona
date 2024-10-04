<?php

//TODO Check if this is still useful and stuff, maybe just replace it with a Container? Or look into replacing it with a .env or smth

namespace Chelona;

/**
 * Storage class for app variables and constants
 */
final class App
{
    /**
     * The array in which the values are stored
     */
    private static array $values = [];

    /**
     * Binds values to our storage container.
     *
     * @param String $key
     * @param mixed $value
     *
     * @return void
     */
    public static function bind(string $key, mixed $value): void
    {
        App::$values[$key] = $value;
    }

    /**
     * Gets a value from storage, based on the provided key.
     * If the key doesn't exist, null is returned instead
     *
     * @param String $key
     *
     * @return Mixed|null
     */
    public static function get(string $key): mixed
    {
        if (isset(App::$values[$key])) {
            return App::$values[$key];
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
        return isset(App::$values[$key]);
    }

    /**
     * Removes a value from storage.
     *
     * @param  string  $key
     *
     * @return void
     */
    public static function forget(string $key): void
    {
        unset(App::$values[$key]);
    }
}
