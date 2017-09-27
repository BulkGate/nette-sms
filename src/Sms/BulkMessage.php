<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;

class BulkMessage implements IMessage
{
	use Nette\SmartObject;

	const TYPE = 'bulk';

	/** @var []Message */
	private $messages = [];


	public function __construct(array $messages)
	{
		foreach ($messages as $message) {
			if ($message instanceof IMessage) {
				$this->messages[] = $message;
			}
		}
	}


	/**
	 * @param IMessage $message
	 */
	public function add(IMessage $message)
	{
		if ($message instanceof IMessage) {
			$this->messages[] = $message;
		}
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		$s = '';

		foreach ($this->messages as $message) {
			$s .= (string) $message . PHP_EOL;
		}
		return $s;
	}


	/**
	 * @return array
	 */
	public function toArray()
	{
		$output = [];

		foreach ($this->messages as $message) {
			if ($message instanceof IMessage) {
				$output[] = $message->toArray();
			}
		}
		return $output;
	}


	/**
	 * @return int
	 */
	public function count()
	{
		return (int) count($this->messages);
	}


	/**
	 * @return string
	 */
	public function getType()
	{
		return self::TYPE;
	}
}
