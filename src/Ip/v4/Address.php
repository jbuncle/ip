<?php

/*
 * The MIT License
 *
 * Copyright 2016 James Buncle <jbuncle@hotmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Ip\v4;

use Ip\InvalidIpException;
use Ip\Util;

/**
 * Represents IPv4 Address.
 *
 * @author James Buncle <jbuncle@hotmail.com>
 */
class Address
{

    const LONG_BROADCAST = 4294967295;
    const LONG_MAX = self::LONG_BROADCAST;

    /**
     * IP address represented as a long integer.
     * 
     * @var int 
     */
    private $ip;

    /**
     * Create instance of IPv4Address.
     * 
     * @param int $ip IP Address represented as an integer.
     */
    private function __construct($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get broadcast IP Address - '255.255.255.255'.
     * 
     * @return Address
     */
    public static function getBroadcast()
    {
        return new Address(self::LONG_BROADCAST);
    }

    public static function fromFloat($long)
    {
        if (!is_numeric($long)) {
            throw new InvalidIpException($long, "Given value '"
            . var_export($long, true)
            . "' is not numeric");
        }
        if ($long < 0 || $long > self::LONG_MAX) {
            throw new InvalidIpException($long, "Given value '"
            . var_export($long, true)
            . "' is not a valid IP integer");
        }
        return new Address($long);
    }

    public static function fromValue($value)
    {
        if (is_numeric($value)) {
            return self::fromFloat($value);
        } elseif (is_string($value)) {
            return self::fromString($value);
        } elseif (is_array($value)) {
            return self::fromArray($value);
        } else {
            throw new InvalidIpException($value, "Given value '"
            . var_export($value, true)
            . "' is not in an expected type or format");
        }
    }

    public static function fromArray(array $array)
    {
        $ipArray = array();
        foreach ($array as $key => $value) {
            $ipArray[$key] = self::fromValue($value);
        }
        return $ipArray;
    }

    /**
     * 
     * @param string $string
     * 
     * @return Address
     * @throws InvalidIpException
     */
    public static function fromString($string)
    {
        if (!Util::isIPv4($string)) {
            throw new InvalidIpException($string, "Given value '"
            . var_export($string, true)
            . "' is not a valid IPv4 string");
        }
        return self::fromFloat(Util::ipv4ToFloat($string));
    }

    /**
     * Get IP address formatted in dot notation.
     * 
     * @return string
     */
    public function __toString()
    {
        return long2ip($this->ip);
    }

    /**
     * Get IP address represented as a long integer.
     * 
     * @return string
     */
    public function asLong()
    {
        return $this->ip;
    }
}
