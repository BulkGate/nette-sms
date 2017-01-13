<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

interface ISender
{
    const MESSAGE = "message";
    const SENDER  = "sender";
    const UNICODE = "unicode";
    const FLASH   = "flash";

    /**
     * @param bool $unicode
     * @return ISender
     */
    public function unicode($unicode = TRUE);

    /**
     * @param bool $flash
     * @return ISender
     */
    public function flash($flash = TRUE);

    /**
     * @param ISenderSettings $senderSettings
     * @return ISender
     */
    public function setSenderSettings(ISenderSettings $senderSettings);

    /**
     * @param IMessage $message
     * @param array $options
     */
    public function send(IMessage $message, array $options = []);
}
