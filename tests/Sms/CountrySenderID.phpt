<?php

/**
 * Test: Nette\Sms\CountrySenderID
 */

namespace Test;

use Nette;
use Tester\Assert;
use Nette\Sms\CountrySenderID;

require __DIR__ . '/../bootstrap.php';
require __DIR__. '/../../src/Sms/exceptions.php';
require __DIR__. '/../../src/Sms/Gate.php';
require __DIR__. '/../../src/Sms/CountrySenderID.php';

$country = new CountrySenderID("CZ", 1, "");

Assert::same([
    "iso" => "cz",
    "gate" => 1,
    "sender" => ""
], $country->toArray());

$country = new CountrySenderID("CZ", "2", "");
Assert::same([
    "iso" => "cz",
    "gate" => 2,
    "sender" => ""
], $country->toArray());

Assert::exception(function() {
    new CountrySenderID("CZ", -1, "");
}, Nette\Sms\InvalidGateException::class, 'Gate must be in interval <0, 4>');

Assert::exception(function() {
    new CountrySenderID("CZ", 5, "");
}, Nette\Sms\InvalidGateException::class, 'Gate must be in interval <0, 4>');

Assert::exception(function() {
    new CountrySenderID("CZ", 125, "");
}, Nette\Sms\InvalidGateException::class, 'Gate must be in interval <0, 4>');
