<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2016 Lukáš Piják (http://lukaspijak.com)
 */

namespace Nette\Sms;

use Nette;

class Message implements IMessage
{
    use Nette\SmartObject;

    const TYPE = "transaction";

    /** @var string */
    private $phone_number;

    /** @var string */
    private $text = "";

    /** @var string */
    private $iso = "";

    /**
     * Message constructor.
     * @param $phone_number
     * @param string $text
     * @param null|string $iso
     */
    public function __construct($phone_number, $text = "", $iso = "")
    {
        $this->phoneNumber($phone_number)->text($text)->iso($iso);
    }

    /**
     * @param string $phone_number
     * @return $this
     */
    public function phoneNumber($phone_number)
    {
        $this->phone_number = $this->formatNumber($phone_number);

        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param string $iso
     * @return $this
     */
    public function iso($iso)
    {
        if(strlen($iso) === 2 || strlen($iso) === 0) {
            $this->iso = strtolower($iso);
            return $this;
        }
        throw new InvalidMessageException("Invalid message ISO country code");
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->phone_number.": ".$this->text;
    }

    /**
     * @param string $number
     * @return string
     */
    public function formatNumber($number)
    {
        $number = preg_replace(["/ /", "/-/", "/\(/", "/\)/", "/\./", "/\//", "/\\\/"], ["", "", "", "", "", "", ""], trim($number));

        if(substr($number, 0, 2) === "00") {
            $number = substr($number, 2, strlen($number));
        }
        elseif(substr($number, 0, 1) === "+") {
            $number = substr($number, 1, strlen($number));
        }

        return $number;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            self::PHONE_NUMBER => $this->phone_number,
            self::TEXT         => $this->text,
            self::ISO          => $this->iso,
        ];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE;
    }
}
