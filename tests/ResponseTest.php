<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Chelona\Response;

final class ResponseTest extends TestCase
{
	public function testResponseDataCanBePlain(): void
	{
		// Update with random string generation?
		$this->expectOutputString('foo');
		Response::plain('foo');
	}

	// Doesn't work as of yet, due to header side effect
	// public function testResponseDataCanBeJson(): void
	// {
	// 	// Data - look into proper faking
	// 	$foo['bar'] = 'baz';

	// 	// Check headers?
	// 	$this->expectOutputString(json_encode($foo));
	// 	Response::json(json_encode($foo));
	// }
}
