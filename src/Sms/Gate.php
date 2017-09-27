<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;

class Gate
{
	use Nette\StaticClass;

	const ISO = 'iso';

	const GATE = 'gate';

	const SENDER = 'sender';

	const GATE_SYSTEM_NUMBER = 'gSystem';

	const GATE_SHORT_CODE = 'gShort';

	const GATE_TEXT_SENDER = 'gText';

	const GATE_OWN_NUMBER = 'gOwn';

	const GATE1 = 0;

	const GATE2 = 1;

	const GATE3 = 2;

	const GATE4 = 3;

	const GATE5 = 4;
}
