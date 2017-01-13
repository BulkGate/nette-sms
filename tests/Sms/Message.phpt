<?php

/**
 * Test: Nette\Sms\Message
 */

namespace Test;

use Nette;
use Tester\Assert;
use Nette\Sms\Message;

require __DIR__ . '/../bootstrap.php';
require __DIR__. '/../../src/Sms/exceptions.php';
require __DIR__. '/../../src/Sms/IMessage.php';
require __DIR__. '/../../src/Sms/Message.php';

$number = "420777888666";
$text = "test message";
$iso = "cz";

$message = new Message($number, $text, $iso);
Assert::same(["phoneNumber" => $number, "text" => $text, "iso" => $iso], $message->toArray());

Assert::same($number.": ".$text, (string)$message);

$numberNew = "777999888";
$textNew   = "Hello Nette!";
$isoNew = "SK";

$message->text($textNew)->phoneNumber($numberNew)->iso($isoNew);
Assert::same(["phoneNumber" => $numberNew, "text" => $textNew, "iso" => strtolower($isoNew)], $message->toArray());
Assert::notSame(["phoneNumber" => $number, "text" => $text, "iso" => $iso], $message->toArray());

$message = new Message("+420-(777)/123456", $textNew, $isoNew);
Assert::same(["phoneNumber" => "420777123456", "text" => $textNew, "iso" => strtolower($isoNew)], $message->toArray());
$message->phoneNumber("+420-(777)/654321");

$message = new Message("777 444 666");
Assert::same(["phoneNumber" => "777444666", "text" => "", "iso" => ''], $message->toArray());

Assert::exception(function() use ($message) {
    $message->iso("cze");
}, Nette\Sms\InvalidMessageException::class, 'Invalid message ISO country code');

Assert::same("420777888999", $message->formatNumber("420777888999"));
Assert::same("420777888999", $message->formatNumber("+420777888999"));
Assert::same("420777888999", $message->formatNumber("00420777888999"));
Assert::same("420777888999", $message->formatNumber("   0 042  077  788  --  89/9\\9"));
Assert::same("420777888999", $message->formatNumber("420(777)888 999"));
Assert::same("420777888999", $message->formatNumber("+420(777)888 9 9 9"));
Assert::same("420777888999", $message->formatNumber("+420(777)-88-89-99"));
Assert::same("420777888999", $message->formatNumber("420 777 888 999"));
Assert::same("420777888999", $message->formatNumber("42077.7888.999"));
Assert::same("420777888999", $message->formatNumber("42/0777/88\\899\\9"));
