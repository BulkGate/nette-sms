<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Nette\Bridges\SmsTracy;

use Nette;
use Tracy;


/**
 * User panel for Debugger Bar.
 */
class SmsPanel implements Tracy\IBarPanel
{
	use Nette\SmartObject;

	/** @var Nette\Sms\Connection */
	private $connection;

	/** @var int */
    private $count;


	public function __construct(Nette\Sms\IConnection $connection)
	{
		$this->connection = $connection;
	}


	/**
	 * Renders tab.
	 * @return string
	 */
	public function getTab()
	{
		if (headers_sent() && !session_id()) {
			return;
		}

		ob_start(function () {});

		$info = $this->connection->getInfo();

		$this->count = 0;

		if (is_array($info) && count($info)) {
			foreach ($info as $i) {
				if ($i->request['action'] === 'transaction') {
					$this->count++;

				} elseif ($i->request['action'] === 'bulk') {
					$this->count += count($i->request['data']['message']);
				}
			}
		}

		$count = $this->count;

		require __DIR__ . '/templates/SmsPanel.tab.phtml';

		return ob_get_clean();
	}


	/**
	 * Renders panel.
	 * @return string
	 */
	public function getPanel()
	{
		ob_start(function () {});

		$info = $this->connection->getInfo(true);

		$count = $this->count;

		require __DIR__ . '/templates/SmsPanel.panel.phtml';

		return ob_get_clean();
	}
}
