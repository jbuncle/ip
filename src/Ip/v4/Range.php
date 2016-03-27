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

use Ip\Util;
use phpseclib\Math\BigInteger;

/**
 * IPv4 Range.
 *
 * @author James Buncle <jbuncle@hotmail.com>
 */
class Range
{

    /**
     * Start IP address.
     *
     * @var Address
     */
    private $startIp;

    /**
     * End IP address.
     *
     * @var Address
     */
    private $endIp;

    /**
     * Constructor.
     *
     * @param Address $startIp
     * @param Address $endIp
     */
    public function __construct(Address $startIp, Address $endIp)
    {
        $this->startIp = $startIp;
        $this->endIp = $endIp;
    }

    public static function rangeFromCidr($cidr)
    {
        $cidr = explode('/', $cidr);
        $ipLong = new BigInteger(Util::ipv4ToFloat($cidr[0]));
        $leadingBits = intval($cidr[1]);

        // Create the mask from the leading bits
        $mask = new BigInteger(0);
        for ($index = 0; $index < 32; $index++) {
            $mask = $mask->multiply(new BigInteger(2));
            $mask = $mask->add(new BigInteger(1));
        }

//        $mask = $mask->_rshift($leadingBits);
        for ($index = 0; $index < (32 - $leadingBits); $index++) {
            $result = $mask->divide(new BigInteger(2));
            $mask = new BigInteger($result[0]);
        }
//        $mask = $mask->_lshift($leadingBits);
        for ($index = 0; $index < (32 - $leadingBits); $index++) {
            $mask = $mask->multiply(new BigInteger(2));
        }

        // Apply the mask to get get the start IP
        $startIp = $ipLong->bitwise_and($mask);

        //Apply the inverse of the mask to get the end IP
        $inverseMask = $mask->bitwise_not();
        $endIp = $ipLong->bitwise_or($inverseMask);

        //Return IP instances as array pair.
        $startIpAddress = Address::fromFloat(hexdec($startIp->toHex()));
        $endIpAddress = Address::fromFloat(hexdec($endIp->toHex()));
        return new Range($startIpAddress, $endIpAddress);
    }

    public static function fromFloats($start, $end)
    {
        return new Range(Address::fromFloat($start), Address::fromFloat($end));
    }

    /**
     * Create IP range from a start and end string (in dot notation).
     *
     * @param string $start Start IP represented as a string.
     * @param string $end   End IP represented as a string.
     *
     * @return Range
     */
    public static function fromStrings($start, $end)
    {
        return new Range(Address::fromString($start), Address::fromString($end));
    }

    /**
     * Check if the given IP is within the range of this instance (inclusive).
     *
     * @param Address $ip
     *
     * @return bool
     */
    public function isInRange(Address $ip)
    {
        return $ip->asLong() >= $this->getStartIp()->asLong() && $ip->asLong() <= $this->getEndIp()->asLong();
    }

    /**
     * Get array of IP Addresses for this range.
     *
     * @return Address[]
     */
    public function getRange()
    {
        $start = $this->getStartIp()->asLong();
        $end = $this->getEndIp()->asLong();

        $range = array();
        for ($index = $start; $index <= $end; $index++) {
            $range[] = Address::fromFloat($index);
        }
        return $range;
    }

    /**
     * Get the number of IP addresses in this range (inclusive).
     * 
     * @return int
     */
    public function getDistance()
    {
        return $this->getEndIp()->asLong() - $this->getStartIp()->asLong() + 1;
    }

    public function getStartIp()
    {
        return $this->startIp;
    }

    public function getEndIp()
    {
        return $this->endIp;
    }
}
