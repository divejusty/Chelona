<?php

namespace Chelona\Shell\Http;

readonly class Request
{
    public static function uri(): false|string
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, '/');
        $parsedUrl = parse_url($uri, PHP_URL_PATH);

        if (is_string($parsedUrl)) {
            return $parsedUrl;
        }

        return false;
    }

    public static function method(): RequestMethod
    {
        return RequestMethod::from($_SERVER['REQUEST_METHOD']);
    }

    public static function all(): array
    {
        return $_SERVER;
    }
}
