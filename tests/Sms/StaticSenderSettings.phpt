<?php

/**
 * Test: Nette\Sms\StaticSenderSettings
 */

namespace Test;

use Nette;
use Tester\Assert;
use Nette\Sms\StaticSenderSettings;
use Nette\Sms\Gate;


require __DIR__. '/../bootstrap.php';
require __DIR__. '/../../src/Sms/ISenderSettings.php';
require __DIR__. '/../../src/Sms/Gate.php';
require __DIR__. '/../../src/Sms/StaticSenderSettings.php';
require __DIR__. '/../../src/Sms/exceptions.php';

$settings = new StaticSenderSettings();

$system_number = ["static" => [
    Gate::ISO    => "static",
    Gate::GATE   => Gate::GATE_SYSTEM_NUMBER,
    Gate::SENDER => ""
]];

$short_code = ["static" => [
    Gate::ISO    => "static",
    Gate::GATE   => Gate::GATE_SHORT_CODE,
    Gate::SENDER => ""
]];

$text_sender = ["static" => [
    Gate::ISO    => "static",
    Gate::GATE   => Gate::GATE_TEXT_SENDER,
    Gate::SENDER => "Nette"
]];

$own_number = ["static" => [
    Gate::ISO    => "static",
    Gate::GATE   => Gate::GATE_OWN_NUMBER,
    Gate::SENDER => "420777666555"
]];

Assert::same($system_number, $settings->toArray());

$settings->systemNumber();
Assert::same($system_number, $settings->toArray());

$settings->textSender("Nette");
Assert::same($text_sender, $settings->toArray());

$settings->shortCode();
Assert::same($short_code, $settings->toArray());

$settings->ownNumber("420777666555");
Assert::same($own_number, $settings->toArray());

foreach (["Nette framework", "NF"] as $sender)
{
    Assert::exception(function() use ($settings, $sender) {
        $settings->textSender($sender);
    }, Nette\Sms\InvalidSenderException::class, "Text sender length must be between 3 and 13 characters (".strlen($sender)." characters given)");
}

foreach (["", "   ", NULL, FALSE] as $sender)
{
    Assert::exception(function() use ($settings, $sender) {
        $settings->ownNumber($sender);
    }, Nette\Sms\InvalidSenderException::class, "Empty own number value");
}

$settings = new StaticSenderSettings(Gate::GATE_SYSTEM_NUMBER);
Assert::same($system_number, $settings->toArray());

$settings = new StaticSenderSettings(Gate::GATE_TEXT_SENDER, "Nette");
Assert::same($text_sender, $settings->toArray());

$settings = new StaticSenderSettings(Gate::GATE_SHORT_CODE);
Assert::same($short_code, $settings->toArray());

$settings = new StaticSenderSettings(Gate::GATE_OWN_NUMBER, "420777666555");
Assert::same($own_number, $settings->toArray());

Assert::exception(function() {
    new StaticSenderSettings("Nette_sender");
}, Nette\Sms\InvalidSenderException::class, "Unknown sender type");
