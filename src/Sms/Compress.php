<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;

class Compress
{
	use Nette\StaticClass;

	/**
	 * @param $data
	 * @param int $encoding_mode
	 * @return string
	 */
	public static function compress($data, $encoding_mode = 9)
	{
		return base64_encode(gzencode(serialize($data), $encoding_mode));
	}


	/**
	 * @param $data
	 * @return mixed
	 */
	public static function decompress($data)
	{
		return unserialize(gzdecode(base64_decode($data, true)));
	}
}
