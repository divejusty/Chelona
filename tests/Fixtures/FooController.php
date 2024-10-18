<?php

namespace Tests\Fixtures;

use Chelona\Shell\Http\Response;

class FooController
{
    public function index()
    {
        Response::json(['Hello, World!']);
    }
}