<?php

/**
 * Test: Nette\Sms\CountrySenderSettings
 */

namespace Test;

use Nette;
use Nette\Sms\CountrySenderID;
use Nette\Sms\CountrySenderSettings;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../../src/Sms/exceptions.php';
require __DIR__ . '/../../src/Sms/Gate.php';
require __DIR__ . '/../../src/Sms/ISenderSettings.php';
require __DIR__ . '/../../src/Sms/CountrySenderID.php';
require __DIR__ . '/../../src/Sms/CountrySenderSettings.php';

$array = [
	'cz' => ['iso' => 'cz', 'gate' => 1, 'sender' => ''],
	'sk' => ['iso' => 'sk', 'gate' => 2, 'sender' => ''],
	'gb' => ['iso' => 'gb', 'gate' => 1, 'sender' => ''],
	'de' => ['iso' => 'de', 'gate' => 3, 'sender' => 'Nette'],
	'us' => ['iso' => 'us', 'gate' => 1, 'sender' => ''],
	'ru' => ['iso' => 'ru', 'gate' => 4, 'sender' => '420777444555'],
];

$settingUS = new CountrySenderID('US', 1, '');
$settingGB = new CountrySenderID('GB', 1, '');

$settings = new CountrySenderSettings([new CountrySenderID('CZ', 1, ''), new CountrySenderID('RU', 4, '420777444555')]);

$settings->add('SK', 2, '');
$settings->add(new CountrySenderID('DE', 3, 'Nette'));
$settings->add([$settingGB, $settingUS]);

Assert::equal($array, $settings->toArray());

$settings->remove('SK');
unset($array['sk']);

Assert::equal($array, $settings->toArray());

Assert::exception(function () use ($settings) {
	$settings->add('cze');
}, Nette\Sms\InvalidGateException::class, 'Invalid message ISO country code');
