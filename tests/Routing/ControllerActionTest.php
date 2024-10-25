<?php

declare(strict_types=1);

namespace Tests\Routing;

use Chelona\Shell\Routing\ControllerAction;
use Chelona\Shell\Routing\RouterException;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\FooController;

final class ControllerActionTest extends TestCase
{
    public function testNonexistentMethod()
    {
        $this->expectException(RouterException::class);
        new ControllerAction(FooController::class, 'nonexistentMethod');
        $this->expectExceptionMessageMatches('/Method .* not found in class .*/');
    }
}
