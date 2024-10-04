<?php

namespace Chelona\Shell\Http;

class Request
{
    public static function uri(): false|array|int|string|null
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, '/');
        return parse_url($uri, PHP_URL_PATH);
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function all(): array
    {
        return $_SERVER;
    }
}
