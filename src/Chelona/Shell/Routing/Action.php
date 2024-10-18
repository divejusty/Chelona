<?php

namespace Chelona\Shell\Routing;

readonly class Action
{
    /**
     * @throws \Chelona\Shell\Routing\RouterException
     */
    public function __construct(public string $controller, public string $method)
    {
        if (! method_exists($this->controller, $this->method)) {
            throw new RouterException("Undefined method `$this->method` in endpoint `$this->controller`.");
        }
    }
}
