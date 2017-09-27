<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;


interface IConnection
{
	/**
	 * @param $action
	 * @param array $data
	 * @param bool $compress
	 * @return ServerResponse
	 */
	public function send($action, array $data, $compress = true);

	public function getInfo();
}
