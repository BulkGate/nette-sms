<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;

class Sender implements ISender
{
    use Nette\SmartObject;

    /** @var Connection */
    private $connection;

    /** @var ISenderSettings|NULL  */
    private $senderSettings;

    /** @var bool */
    private $unicode = FALSE;

    /** @var bool */
    private $flash = FALSE;

    /**
     * TransactionSender constructor.
     * @param IConnection $connection
     */
    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param bool $unicode
     * @return $this
     */
    public function unicode($unicode = TRUE)
    {
        $this->unicode = (bool) $unicode;

        return $this;
    }

    /**
     * @param bool $flash
     * @return $this
     */
    public function flash($flash = TRUE)
    {
        $this->flash = (bool) $flash;

        return $this;
    }

    /**
     * @param ISenderSettings $senderSettings
     * @return $this
     */
    public function setSenderSettings(ISenderSettings $senderSettings)
    {
        $this->senderSettings = $senderSettings;

        return $this;
    }

    /**
     * @param IMessage $message
     * @param array $options
     * @return ServerResponse
     */
    public function send(IMessage $message, array $options = [])
    {
        return $this->connection->send($message->getType(), [
            self::MESSAGE => $message->toArray(),
            self::SENDER  => $this->senderSettings instanceof ISenderSettings ? $this->senderSettings->toArray() : [],
            self::UNICODE => $this->unicode,
            self::FLASH   => $this->flash
        ]);
    }
}
