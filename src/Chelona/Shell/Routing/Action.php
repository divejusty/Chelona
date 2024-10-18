<?php

namespace Chelona\Shell\Routing;

class Action
{
    public function __construct(public readonly string $controller, public readonly string $method)
    {
    }


    public function getEndpoint(string $endpointPath)
    {
        $endpoint = '\\' . $endpointPath . '\\'. $this->controller;
        return new $endpoint();
    }

}
