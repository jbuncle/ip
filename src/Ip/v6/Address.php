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

namespace Ip\v6;

/**
 * Address
 *
 * @author James Buncle <jbuncle@hotmail.com>
 */
class Address
{

    /**
     * Array of integers representing each part of the IP address.
     *
     * @var int[]
     */
    private $ip;

    public static function fromString($ip)
    {
        return new Address(self::ipv6ToDecArray($ip));
    }

    /**
     *
     * @param array $ip
     */
    private function __construct(array $ip)
    {
        $this->ip = $ip;
    }

    public function __toString()
    {
        return implode(':', self::toHexArr($this->ip));
    }

    private static function toHexArr(array $arr)
    {
        $hexArr = array();
        foreach ($arr as $key => $value) {
            if ($value === 0) {
                $hexArr[$key] = '';
            } else {
                $hexArr[$key] = strtoupper(dechex($value));
            }
        }
        return $hexArr;
    }

    /**
     * IP addres represented as an array of integers.
     *
     * @return int[]
     */
    private function asArray()
    {
        return $this->ip;
    }

    /**
     * Compare this to the given object.
     *
     * @param \Ip\v6\Address $address
     *
     * @return int -1 if this is less than given, 0 if equal or 1 if greater.
     */
    public function compareTo(Address $address)
    {
        $thisArray = $this->asArray();
        $thatArray = $address->asArray();
        foreach ($thisArray as $key => $value) {
            $diff = $value - $thatArray[$key];
            if ($diff !== 0) {
                return ($diff < 0) ? -1 : 1;
            }
        }
        return 0;
    }

    /**
     * Convert IP address to float.
     *
     * Uses multiplication over binary shift as binary operation can result in
     * the integer sign being misinterpreteed (e.g. 255.255.255.255 = -1).
     *
     * @param string $ip
     * @return float
     */
    private static function ipv6ToDecArray($ip)
    {
        $parts = explode(":", $ip);
        $decParts = array();
        for ($index = 0; $index < 8; $index++) {
            $decParts[$index] = hexdec($parts[$index]);
        }
        return $decParts;
    }
}
