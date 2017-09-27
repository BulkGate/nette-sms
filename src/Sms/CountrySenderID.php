<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;

class CountrySenderID
{
	use Nette\SmartObject;

	/** @var string */
	private $iso;

	/** @var int */
	private $gate = Gate::GATE1;

	/** @var string */
	private $sender = '';


	/**
	 * CountrySenderID constructor.
	 * @param $iso
	 * @param $gate
	 * @param string $sender
	 */
	public function __construct($iso, $gate = Gate::GATE1, $sender = '')
	{
		$this->iso = strtolower($iso);
		$this->gate = $gate;
		$this->sender = $sender;

		if ((int) $this->gate < Gate::GATE1 || (int) $this->gate > Gate::GATE5) {
			throw new InvalidGateException('Gate must be in interval <0, 4>');
		}
	}


	/**
	 * @return string
	 */
	public function getIso()
	{
		return $this->iso;
	}


	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			Gate::ISO => (string) $this->iso,
			Gate::GATE => (int) $this->gate,
			Gate::SENDER => (string) $this->sender,
		];
	}
}
