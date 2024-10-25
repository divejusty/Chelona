<?php

namespace Chelona\Shell\Routing;

readonly class ControllerAction implements Actionable
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

    public function call(?array $args = []): mixed
    {
        return (new $this->controller())->{$this->method}(...$args);
    }
}
