<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;

class CountrySenderSettings implements ISenderSettings
{
    use Nette\SmartObject;
    
    /** @var []CountrySenderID */
    private $settings = [];

    public function __construct(array $settings = [])
    {
        foreach ($settings as $setting) {
            if($setting instanceof CountrySenderID) {
                $this->settings[$setting->getIso()] = $setting;
            }
        }
    }

    /**
     * @param $iso string|CountrySenderID|array CountrySenderID
     * @param int $gate
     * @param string $sender
     */
    public function add($iso, $gate = Gate::GATE1, $sender = "")
    {
        if($iso instanceof CountrySenderID) {
            $this->settings[$iso->getIso()] = $iso;
        }
        elseif(is_array($iso)) {
            foreach ($iso as $setting) {
                if($setting instanceof CountrySenderID) {
                    $this->settings[$setting->getIso()] = $setting;
                }
            }
        }
        else if(strlen($iso) === 2) {
            $this->settings[strtolower($iso)] = new CountrySenderID($iso, $gate, $sender);
        }
        else {
            throw new InvalidGateException("Invalid message ISO country code");
        }

    }

    /**
     * @param $iso
     * @return bool
     */
    public function remove($iso)
    {
        $iso = strtolower($iso);

        if(isset($this->settings[$iso])) {
            unset($this->settings[$iso]);
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];

        foreach ($this->settings as $iso => $setting) {
            $array[$iso] = $setting->toArray();
        }

        return $array;
    }
}
