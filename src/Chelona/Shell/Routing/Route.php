<?php

namespace Chelona\Shell\Routing;

use Chelona\Shell\Http\RequestMethod;

/**
 * Defines the Route object used in routing for http requests
 */
class Route
{
    private array $params = [];

    public function __construct(private readonly string $path, private readonly string $endpoint, private readonly string $action, private readonly RequestMethod $method)
    {
        $params = [];
        preg_match_all('/(\{[A-z]*\})/', $path, $params);

        if (count($params[0]) > 0) {
            $pathParts = explode('/', $this->path);
            foreach ($pathParts as $pos => $part) {
                if (in_array($part, $params[0])) {
                    $this->params[$pos] = $part;
                }
            }
        }
    }

    /**
     * Creates a route for a GET request.
     *
     * @param string $path
     * @param string $endpoint
     *
     * @return Route
     */
    public static function get(string $path, string $endpoint): Route
    {
        return static::createRoute($path, $endpoint, RequestMethod::GET);
    }

    /**
     * Creates a route for a POST request.
     *
     * @param string $path
     * @param string $endpoint
     *
     * @return Route
     */
    public static function post(string $path, string $endpoint): Route
    {
        return static::createRoute($path, $endpoint, RequestMethod::POST);
    }

    /**
     * Creates a route for a PUT request.
     *
     * @param string $path
     * @param string $endpoint
     *
     * @return Route
     */
    public static function put(string $path, string $endpoint): Route
    {
        return static::createRoute($path, $endpoint, RequestMethod::PUT);
    }

    /**
     * Creates a route for a DELETE request.
     *
     * @param string $path
     * @param string $endpoint
     *
     * @return Route
     */
    public static function delete(string $path, string $endpoint): Route
    {
        return static::createRoute($path, $endpoint, RequestMethod::DELETE);
    }

    /**
     * Creates a route for a PATCH request.
     *
     * @param string $path
     * @param string $endpoint
     *
     * @return Route
     */
    public static function patch(string $path, string $endpoint): Route
    {
        return static::createRoute($path, $endpoint, RequestMethod::PATCH);
    }

    private static function createRoute(string $path, string $action, RequestMethod $method): Route
    {
        $route = explode('@', $action);
        $route = new Route(
            $path,
            $route[0],
            $route[1],
            $method
        );
        Router::add(static::parseRoute($path), $route);

        return $route;
    }

    /**
     * Returns the Route's path.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    private static function parseRoute(string $path): string
    {
        $path = preg_replace('/(\{[A-z]*\})/', '(([A-z]|[0-9])+)', $path);
        $path = str_replace('/', '\/', $path);
        return '/\{' . $path . '\}/';
    }

    private function getEndpoint($endpointPath)
    {
        $endpoint = '\\' . $endpointPath . '\\'. $this->endpoint;
        return new $endpoint();
    }

    private function extractParams(string $uri): array
    {
        $params = [];
        $uriParts = explode('/', $uri);
        foreach ($this->params as $pos => $param) {
            $params[$pos] = $uriParts[$pos];
        }
        return $params;
    }

    /**
     * Calls the endpoint associated with the Route.
     * @throws \Chelona\Shell\Routing\RouterException
     */
    public function call($endpointPath, $uri)
    {
        $class = $this->getEndpoint($endpointPath);
        if (! method_exists($class, $this->action)) {
            throw new RouterException('Undefined method `' . $this->action . '` in endpoint `' . $this->endpoint . '`.');
        }

        if (count($this->params) > 0) {
            $params = $this->extractParams($uri);
            return $class->{$this->action}(...$params);
        }

        return $class->{$this->action}();
    }

    /**
     * Checks whether the provided method matches the method of this route.
     */
    public function isMethod(RequestMethod|string $method): bool
    {
        if (is_string($method)) {
            $method = RequestMethod::from($method);
        }
        return $this->method === $method;
    }

}
