<?php

/**
 * Test: Nette\Object magic @methods and types.
 */

namespace Test;

use Nette;
use Nette\Sms\Compress;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../../src/Sms/Compress.php';



Assert::same('H4sIAAAAAAACC0u0MrKqLrYytlJKTEpWss60MjQyhpII0VoASinDoSYAAAA=', Compress::compress(['abc' => 123, '123' => 'abc']));

Assert::same('H4sIAAAAAAAEC0u0MrKqLrYytlJKTEpWss60MjQyhpII0VoASinDoSYAAAA=', Compress::compress(['abc' => 123, '123' => 'abc'], 1));

Assert::same(['abc' => 123, '123' => 'abc'], Compress::decompress('H4sIAAAAAAAEC0u0MrKqLrYytlJKTEpWss60MjQyhpII0VoASinDoSYAAAA='));

Assert::same(['abc' => 123, '123' => 'abc'], Compress::decompress(Compress::compress(['abc' => 123, '123' => 'abc'])));

$json = json_encode([
	'status' => '-1',
	'type' => 'error',
	'message' => 'Unknown action',
	'compress' => false,
	'data' => [
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
		123456789,
	],
]);

Assert::true(strlen($json) > strlen(Compress::compress($json)));
