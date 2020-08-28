<?php

namespace Chelona\Shell\Data;

class Container
{

	/****************************
	 * Private Fields + Methods *
	 ***************************/

	private $data = [];

	private function __construct($data)
	{
		$this->data = $data;
	}

	/******************
	 * Static Methods *
	 *****************/

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

	/**********************
	 * Non-Static Methods *
	 *********************/

	// Method ideas: Filter, exists, find, add/append, remove, sorting

	/**
	 * Maps the given callback over the data in the container, in place.
	 * 
	 * @param callable $callback 
	 * 
	 * @return Container
	 */
	public function map(callable $callback): Container
	{
		$this->data = array_map($callback, $this->data);

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


	/**********
	* Getters *
	**********/

	/**
	 * Return the contents of the Container as an array.
	 * 
	 * @return array
	 */
	public function toArray(): array
	{
		return $this->data;
	}

}
