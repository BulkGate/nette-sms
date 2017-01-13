<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;

class SmsException extends Nette\InvalidStateException
{
}

class InvalidGateException extends SmsException
{
}

class ConnectionException extends SmsException
{
}

class InvalidSenderException extends SmsException
{
}

class InvalidMessageException extends SmsException
{
}
