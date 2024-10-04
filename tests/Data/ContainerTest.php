<?php

declare(strict_types=1);

namespace Tests\Data;

use PHPUnit\Framework\TestCase;

use Chelona\Shell\Data\Container;

final class ContainerTest extends TestCase
{
	protected function setUp(): void
	{
		$this->values = [1, 2, 3];
		$this->container = Container::create(1, 2, 3);
	}

	public function testCreate()
	{
		$containerArray = Container::create($this->values);

		$this->assertEquals($this->values, $this->container->toArray());
		$this->assertEquals($this->container->toArray(), $containerArray->toArray());
	}

	public function testEmpty()
	{
		$container = Container::empty();

		$this->assertEquals([], $container->toArray());
	}

	public function testMap()
	{
		$this->container->map(function ($elem) {
			return $elem + 1;
		});

		$this->assertEquals([2,3,4], $this->container->toArray());
	}

	public function testClone()
	{
		$containerClone = $this->container->clone();

		$this->assertEquals($this->container->toArray(), $containerClone->toArray());
	}
}
