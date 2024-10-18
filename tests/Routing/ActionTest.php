<?php

declare(strict_types=1);

namespace Tests\Routing;

use Chelona\Shell\Routing\Action;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\FooController;

final class ActionTest extends TestCase
{
    public function testNonexistentMethod()
    {
        $this->expectException(\Chelona\Shell\Routing\RouterException::class);
        new Action(FooController::class, 'nonexistentMethod');
        $this->expectExceptionMessageMatches('/Method .* not found in class .*/');
    }
}
