<?php

namespace Chelona\Shell\Data;

class Container
{
	// Private Fields + Methods //

	/**
	 * The data stored in the container.
	 * 
	 * @var array
	 */
	private $data = [];

	/**
	 * The number of items stored in the container.
	 * 
	 * @var int
	 */
	private $count;

	/**
	 * Flag to see if named keys are used. Currently always false. Might receive updates in the future.
	 * 
	 * @var bool $namedKeys
	 */
	private $namedKeys = false;

	private function __construct($data)
	{
		$this->data = $data;
		$this->count = count($data);
	}

	private function updateCount()
	{
		$this->count = count($this->data);
	}

	// INTERFACE //

	// Static Methods //

	// TODO: Look into creation of arrays with named keys and extra functionality with that

	/**
	 * Create a new Container instance with the specified data as it's contents.
	 * 
	 * @return Container 
	 */
	public static function create(... $data): Container
	{
		// Check if $data is off the form [[...]] due to a single array being passed into it
		// If so, simplify the creation
		if(is_array($data) && count($data) == 1 && is_array($data[0])) {
			return new Container($data[0]);
		}

		return new Container($data);
	}

	/**
	 * Create a new, empty Container instance.
	 * 
	 * @return Container
	 */
	public static function empty(): Container
	{
		return new Container([]);
	}

	// Non-Static Methods //

	// Method ideas: exists, find, add/append, remove, sorting

	/**
	 * Maps the given callback over the data in the container, in place.
	 * 
	 * @param callable $callback 
	 * 
	 * @return Container
	 */
	public function map(callable $callback): Container
	{
		$this->data = \array_map($callback, $this->data);

		return $this;
	}

	/**
	 * Filters the contained data using the given callback, in place.
	 * 
	 * @param callable $callback
	 * 
	 * @return Container
	 */
	public function filter(callable $callback): Container
	{
		$this->data = \array_filter($this->data, $callback); // TODO: look into support for (key, val) callbacks

		if(!$this->namedKeys) {
			$this->data = \array_values($this->data);
		}

		$this->updateCount();

		return $this;
	}

	/**
	 * Creates a new Container with the same data as the current one
	 * 
	 * @return Container
	 */
	public function clone(): Container
	{
		return new Container($this->data);
	}

	// Getters //

	/**
	 * Return the contents of the Container as an array.
	 * 
	 * @return array
	 */
	public function toArray(): array
	{
		return $this->data;
	}

	/**
	 * Returns the first element that was stored or null if nothing is present.
	 * 
	 * @return mixed|null
	 */
	public function first()
	{
		if($this->count == 0) {
			return null;
		}

		return $this->data[array_key_first($this->data)];
	}

	/**
	 * Returns the last element that was stored or null if nothing is present.
	 * 
	 * @return mixed|null
	 */
	public function last()
	{
		if($this->count == 0) {
			return null;
		}

		return $this->data[array_key_last($this->data)];
	}

	public function itemCount(): int
	{
		return $this->count;
	}

}
