<?php

/**
 * Test: Nette\Sms\ServerResponse
 */

namespace Test;

use Nette;
use Nette\Sms\Compress;
use Nette\Sms\ServerResponse;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../../src/Sms/ServerResponse.php';
require __DIR__ . '/../../src/Sms/Compress.php';

$response = new ServerResponse([
	'status' => '-1',
	'type' => 'error',
	'message' => 'Unknown action',
	'compress' => false,
	'data' => [],
]);

Assert::same(-1, $response->getStatus());

Assert::same('error', $response->getType());

Assert::same('error', $response->getType());

Assert::same('Unknown action', $response->getMessage());

Assert::same([], $response->getData());

$response = new ServerResponse([
	'status' => '-1',
	'type' => 'error',
	'message' => 'Unknown action',
	'compress' => true,
	'data' => Compress::compress(['123' => 'abc']),
]);

Assert::same(['123' => 'abc'], $response->getData());
