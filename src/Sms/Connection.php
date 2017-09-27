<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;
use Nette\Utils\Json;

class Connection implements IConnection
{
	use Nette\SmartObject;

	const HOST = 'https://smsmidlet.com';

	const API = '/bulkgate/nette.php';

	/** @var  string */
	private $account;

	/** @var  string */
	private $secretKey;

	/** @var array ServerResponse */
	private $responses = [];


	/**
	 * Connection constructor.
	 * @param $account
	 * @param $secretKey
	 */
	public function __construct($account, $secretKey)
	{
		$this->account = $account;
		$this->secretKey = $secretKey;
	}


	/**
	 * @param $action
	 * @param array $data
	 * @param bool $compress
	 * @return ServerResponse
	 */
	public function send($action, array $data, $compress = false)
	{
		$context = stream_context_create(['http' => [
			'method' => 'POST',
			'header' => 'Content-type: application/json',
			'content' => Json::encode($request = [
				'action' => $action,
				'account' => $this->account,
				'secretKey' => $this->secretKey,
				'compress' => $compress,
				'data' => $compress ? Compress::compress($data) : $data,
			]),
		]]);

		$fp = fopen(self::HOST . self::API, 'r', false, $context);

		if ($fp) {
			$result = stream_get_contents($fp);
			fclose($fp);

			$response = new ServerResponse(Json::decode($result, Json::FORCE_ARRAY));
			$request['data'] = $data;
			$this->responses[] = (object) ['request' => $request, 'response' => $response];
			return $response;
		}

		throw new ConnectionException('SMS server is unavailable');
	}


	public function getInfo($delete = false)
	{
		$responses = $this->responses;

		if ($delete) {
			$this->responses = [];
		}
		return $responses;
	}
}
