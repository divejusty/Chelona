<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Chelona\App;

final class AppTest extends TestCase
{
	public function testBindValue(): array
	{
		$key = 'foo';
		$value = 'bar';

		App::bind($key, $value);
		$this->assertEquals(App::get($key), $value);

		return ['key' => $key, 'value' => $value];
	}

	/**
	 * @depends testBindValue
	 */
	public function testHasValue($keyValPair): void
	{
		$this->assertTrue(App::has($keyValPair['key']));
	}

	public function testGetEmptyValue(): void
	{
		$this->assertNull(App::get('baz'));
	}

	/**
	 * @depends testBindValue
	 */
	public function testGetValue($keyValPair): void
	{
		$this->assertEquals($keyValPair['value'], App::get($keyValPair['key']));
	}

	/**
	 * @depends testBindValue
	 */
	public function testForgetValue($keyValPair): void
	{
		$this->assertTrue(App::has($keyValPair['key']));
		App::forget($keyValPair['key']);
		$this->assertFalse(App::has($keyValPair['key']));
	}
}
