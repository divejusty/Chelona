<?php

namespace Chelona\Shell\Routing;

use Chelona\Shell\Http\Request;

class Router
{
    /**
     * The collection of all registered routes in the application
     */
    private static array $routes = [];

    /**
     * The base URL for the application. Will be prepended to all paths.
     */
    private static string $base;

    /**
     * The namespace in which the endpoints reside.
     */
    private static string $endpointPath;

    /**
     * Initialize the router.
     *
     * @param  string  $base Will be used to set the base URL for the application. Defaults to an empty string.
     * @param  string  $endpointPath Will be used to set the namespace for the application. Defaults to an empty string.
     */
    public static function init(string $base = '', string $endpointPath = ''): void
    {
        static::$base = $base;
        static::$endpointPath = $endpointPath;
    }

    /**
     * Adds a route to the collection of routes.
     */
    public static function add($uri, Route $route): void
    {
        static::$routes[$uri] = $route;
    }

    /**
     * @throws \Chelona\Shell\Routing\RouterException
     */
    public static function direct()
    {
        $uri = Request::uri();
        $uri = str_replace(static::$base, '', $uri);
        $method = Request::method();
        $matchUri = '{' . $uri . '}'; // Do this so we can match the whole thing
        foreach (static::$routes as $path => $route) {
            if (preg_match_all($path, $matchUri)) {
                if (!$route->isMethod($method)) {
                    $fullUrl = static::$base . $uri;
                    throw new RouterException("Incorrect method $method->value for route $fullUrl!");
                }

                return $route->call(static::$endpointPath, $uri);
            }
        }

        throw new RouterException('Route ' . static::$base . $uri . ' is not defined');
    }
}
