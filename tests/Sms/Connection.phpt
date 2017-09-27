<?php

/**
 * Test: Nette\Sms\Connection
 */

namespace Test;

use Nette;
use Nette\Sms\Connection;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../../src/Sms/exceptions.php';
require __DIR__ . '/../../src/Sms/IConnection.php';
require __DIR__ . '/../../src/Sms/Compress.php';
require __DIR__ . '/../../src/Sms/Connection.php';
require __DIR__ . '/../../src/Sms/ServerResponse.php';

if (!extension_loaded('openssl')) {
	Tester\Environment::skip('Test requires php_openssl extension to be loaded.');
}

$connection = new Connection('user', 'pass');

$response = new Nette\Sms\ServerResponse((array) json_decode('{"status":"1","type":"echo","message":"OK","compress":false,"data":[]}'));

Assert::equal($response, $connection->send('echo', [], false));
