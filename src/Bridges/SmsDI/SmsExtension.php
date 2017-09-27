<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Bridges\SmsDI;

use Nette;


/**
 * SMS extension for Nette DI.
 */
class SmsExtension extends Nette\DI\CompilerExtension
{
	public $defaults = [
		'account' => null,
		'secretKey' => null,
	];


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		$connection = $builder->addDefinition($this->prefix('connection'))
			->setClass(Nette\Sms\IConnection::class);

		$connection->setFactory(Nette\Sms\Connection::class, ['account' => $config['account'], 'secretKey' => $config['secretKey']]);

		$sender = $builder->addDefinition($this->prefix('sender'))
			->setClass(Nette\Sms\ISender::class);

		$sender->setFactory(Nette\Sms\Sender::class);
	}


	public function afterCompile(Nette\PhpGenerator\ClassType $class)
	{
		$init = $class->getMethod('initialize');

		$line = "\$this->getService('tracy.bar')->addPanel(new Nette\\Bridges\\SmsTracy\\SmsPanel(\$this->getService('" . $this->prefix('connection') . "')));";

		$init->addBody($line);
	}
}
