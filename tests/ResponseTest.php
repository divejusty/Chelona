<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

use Chelona\Shell\Http\Response;

final class ResponseTest extends TestCase
{
	public function testResponseDataCanBePlain(): void
	{
		// Update with random string generation?
		$this->expectOutputString('foo');
		Response::plain('foo');
	}

	/**
     * @runInSeparateProcess
     */
	public function testResponseDataCanBeJson(): void
	{
		// Data - look into proper faking
		$foo['bar'] = 'baz';

		// Check headers?
		Response::json($foo);
		$this->assertJsonStringEqualsJsonString(json_encode($foo), $this->getActualOutput());
	}
}
