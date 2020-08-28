<?php

namespace Chelona\Shell\Http;

/**
 * Handles different response types
 */
class Response
{
	/**
	 * Sends JSON data
	 *
	 * @param array $data
	 *
	 * @return void
	 */
	public static function json(array $data): void
	{
		// TODO: see if this can be extracted
		header('Content-Type: application/json');

		echo json_encode($data);
	}

	/**
	 * Sends plain text
	 *
	 * @param mixed $data
	 *
	 * @return void
	 */
	public static function plain($data): void // TODO: Rename?
	{
		print($data);
	}
}
