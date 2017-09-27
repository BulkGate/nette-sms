<?php

/**
 * Test: Nette\Sms\Message
 */

namespace Test;

use Nette;
use Nette\Sms\BulkMessage;
use Nette\Sms\Compress;
use Nette\Sms\IConnection;
use Nette\Sms\ISenderSettings;
use Nette\Sms\Message;
use Nette\Sms\Sender;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../../src/Sms/exceptions.php';
require __DIR__ . '/../../src/Sms/IMessage.php';
require __DIR__ . '/../../src/Sms/IConnection.php';
require __DIR__ . '/../../src/Sms/ServerResponse.php';
require __DIR__ . '/../../src/Sms/Gate.php';
require __DIR__ . '/../../src/Sms/Compress.php';
require __DIR__ . '/../../src/Sms/Message.php';
require __DIR__ . '/../../src/Sms/BulkMessage.php';
require __DIR__ . '/../../src/Sms/ISender.php';
require __DIR__ . '/../../src/Sms/ISenderSettings.php';
require __DIR__ . '/../../src/Sms/Sender.php';

class MockConnection implements IConnection
{
	public function send($action, array $data, $compress = true)
	{
		return new Nette\Sms\ServerResponse([
			'status' => '-1',
			'type' => '',
			'message' => $action . ' message',
			'compress' => true,
			'data' => $compress ? Compress::compress($data) : $data,
		]);
	}


	public function getInfo()
	{
		return [];
	}
}

class MockSettings implements ISenderSettings
{
	public function toArray()
	{
		return ['abc' => '123'];
	}
}

$action = 'transaction';
$message = new Message('420777888999', 'Hello Nette!', 'cz');

$response = new Nette\Sms\ServerResponse([
	'status' => '-1',
	'type' => '',
	'message' => $action . ' message',
	'compress' => true,
	'data' => Compress::compress([
		'message' => $message->toArray(),
		'sender' => [],
		'unicode' => false,
		'flash' => false,
	]),
]);

$settings = new MockSettings();
$connection = new MockConnection();
$sender = new Sender($connection);
Assert::equal($response, $sender->send($message));

$action = 'bulk';
$bulk = new BulkMessage([$message]);
$response = new Nette\Sms\ServerResponse([
	'status' => '-1',
	'type' => '',
	'message' => $action . ' message',
	'compress' => true,
	'data' => Compress::compress([
		'message' => $bulk->toArray(),
		'sender' => $settings->toArray(),
		'unicode' => true,
		'flash' => true,
	]),
]);

$sender->flash()->unicode()->setSenderSettings($settings);

Assert::equal($response, $sender->send($bulk));
