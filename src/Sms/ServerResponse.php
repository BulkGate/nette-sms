<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;

class ServerResponse
{
	use Nette\SmartObject;

	/** @var int */
	private $status = -1;

	/** @var bool */
	private $compress = false;

	/** @var string */
	private $type = 'unknown';

	/** @var string */
	private $message = '';

	/** @var array|mixed */
	private $data = [];


	/**
	 * ServerResponse constructor.
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		foreach ($data as $key => $item) {
			if ($key === 'status') {
				$this->status = (int) $item;
			} else {
				$this->$key = $item;
			}
		}

		if ($this->compress) {
			$this->data = Compress::decompress($this->data);
		}
	}


	/**
	 * @return int
	 */
	public function getStatus()
	{
		return $this->status;
	}


	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}


	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}


	/**
	 * @return array|mixed
	 */
	public function getData()
	{
		return $this->data;
	}
}
