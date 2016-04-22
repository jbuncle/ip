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

namespace Ip;

/**
 * Utility class for convenience & supporting functions.
 *
 * @author James Buncle <jbuncle@hotmail.com>
 */
class Util
{

    /**
     * Determines if the given string is an IP in v4 dot notation.
     *
     * @param string $string The string to check.
     * @return bool
     */
    public static function isIPv4($string)
    {
        return filter_var($string, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * Determines if the given string is an IP in v6 Hex notation.
     *
     * @param string $string The string to check.
     * @return bool
     */
    public static function isIPv6($string)
    {
        return filter_var($string, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * Convert IP address to float.
     *
     * Uses multiplication over binary shift as binary operation can result in
     * the integer sign being misinterpreteed (e.g. 255.255.255.255 = -1), which
     * occurs when using the ip2long native function on a 32bit OS.
     *
     * @param string $ip
     * @return float
     */
    public static function ipv4ToFloat($ip)
    {
        $parts = explode(".", $ip);
        $res = 0;
        for ($index = 0; $index < 4; $index++) {
            $res += $parts[$index] * pow(hexdec('FF') + 1, 3 - $index);
        }
        return $res;
    }
}
