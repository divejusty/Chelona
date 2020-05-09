<?php

namespace Chelona;

class Response
{
	public static function json($data)
	{
		header('Content-Type: application/json');

		echo json_encode($data);
	}

	public static function plain($data) // TODO: Rename?
	{
		print($data);
	}
}
