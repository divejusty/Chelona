<?php

namespace Chelona\Shell\Routing;

interface Actionable
{
    public function call(?array $args = []): mixed;
}
