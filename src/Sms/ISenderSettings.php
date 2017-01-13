<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

interface ISenderSettings
{
    /**
     * @return array
     */
    public function toArray();
}
