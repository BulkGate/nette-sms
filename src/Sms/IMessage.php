<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

interface IMessage
{
    const PHONE_NUMBER = "phoneNumber";
    const TEXT         = "text";
    const ISO          = "iso";

    /**
     * @return string
     */
    public function __toString();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function getType();
}
