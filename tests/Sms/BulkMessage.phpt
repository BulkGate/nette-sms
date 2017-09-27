<?php

/**
 * Test: Nette\Sms\BulkMessage
 */

namespace Test;

use Nette;
use Nette\Sms\Message;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../../src/Sms/exceptions.php';
require __DIR__ . '/../../src/Sms/IMessage.php';
require __DIR__ . '/../../src/Sms/Message.php';
require __DIR__ . '/../../src/Sms/BulkMessage.php';

$number = '420777888666';
$text = 'test message';
$iso = 'cz';

$numberNew = '777999888';
$textNew = 'Hello Nette!';
$isoNew = 'SK';

$bulk = new Nette\Sms\BulkMessage([new Message($number, $text, $iso), new Message($numberNew, $textNew, $isoNew), [], 'abc', 123]);

Assert::same('bulk', $bulk->getType());

Assert::same(
	[
		['phoneNumber' => $number, 'text' => $text, 'iso' => strtolower($iso)],
		['phoneNumber' => $numberNew, 'text' => $textNew, 'iso' => strtolower($isoNew)],
	],
	$bulk->toArray()
);

Assert::equal(2, $bulk->count());

$message = new Message($number, $text, $iso);
$bulk->add($message);

Assert::same(
	[
		['phoneNumber' => $number, 'text' => $text, 'iso' => strtolower($iso)],
		['phoneNumber' => $numberNew, 'text' => $textNew, 'iso' => strtolower($isoNew)],
		$message->toArray(),
	],
	$bulk->toArray()
);

Assert::equal(3, $bulk->count());

Assert::same(
	'420777888666: test message' . PHP_EOL .
	'777999888: Hello Nette!' . PHP_EOL .
	'420777888666: test message' . PHP_EOL,
	(string) $bulk);
