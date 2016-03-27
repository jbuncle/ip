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

use PHPUnit_Framework_TestCase;

/**
 * Tests for Ip\v4\Range.
 *
 * @author James Buncle <jbuncle@hotmail.com>
 */
class RangeTest extends PHPUnit_Framework_TestCase
{

    public function stringRanges()
    {
        return array(
            array('240.66.61.235', '240.66.61.245', 11),
            array('255.255.255.0', '255.255.255.255', 256),
            array('0.0.0.0', '255.255.255.255', 4294967296),
            array('0.0.0.0', '0.0.0.1', 2),
            array('255.255.255.255', '255.255.255.255', 1),
        );
    }

    /**
     * @dataProvider stringRanges
     */
    public function testFromStrings($start, $end, $expectedLength)
    {
        $range = Range::fromStrings($start, $end);
        $this->assertEquals($expectedLength, $range->getDistance());
        $this->assertEquals($start, (string) $range->getStartIp());
        $this->assertEquals($end, (string) $range->getEndIp());
    }

    public function floatRanges()
    {
        return array(
            array(4030873067, 4030873077, 11),
            array(4294967040, 4294967295, 256),
            array(0, 4294967295, 4294967296),
            array(0, 1, 2),
            array(4294967295, 4294967295, 1),
        );
    }

    /**
     * @dataProvider floatRanges
     */
    public function testFromFloats($start, $end, $expectedLength)
    {
        $range = Range::fromFloats($start, $end);
        $this->assertEquals($expectedLength, $range->getDistance());
        $this->assertEquals($start, $range->getStartIp()->asLong());
        $this->assertEquals($end, $range->getEndIp()->asLong());
    }

    public function testIsInRange()
    {
        $range = Range::fromStrings('207.15.124.153', '207.15.124.163');

        $this->assertTrue($range->isInRange(Address::fromString('207.15.124.153')));
        $this->assertTrue($range->isInRange(Address::fromString('207.15.124.163')));
        $this->assertTrue($range->isInRange(Address::fromString('207.15.124.160')));

        $this->assertFalse($range->isInRange(Address::fromString('207.15.124.152')));
        $this->assertFalse($range->isInRange(Address::fromString('207.15.124.164')));
    }

    /**
     * @todo   Implement testGetRange().
     */
    public function testGetRange()
    {
        $range = Range::fromStrings('66.44.147.103', '66.44.147.108');

        $arr = $range->getRange();
        $this->assertEquals('66.44.147.103', (string) $arr[0]);
        $this->assertEquals('66.44.147.104', (string) $arr[1]);
        $this->assertEquals('66.44.147.105', (string) $arr[2]);
        $this->assertEquals('66.44.147.106', (string) $arr[3]);
        $this->assertEquals('66.44.147.107', (string) $arr[4]);
        $this->assertEquals('66.44.147.108', (string) $arr[5]);
    }

    public function cidrs()
    {
        return array(
            array('255.255.255.255/1', '128.0.0.0', '255.255.255.255'),
            array('116.99.223.226/1', '0.0.0.0', '127.255.255.255'),
            array('151.88.140.186/28', '151.88.140.176', '151.88.140.191'),
            array('23.124.111.130/31', '23.124.111.130', '23.124.111.131'),
            array('43.102.76.207/1', '0.0.0.0', '127.255.255.255'),
            array('253.37.176.84/21', '253.37.176.0', '253.37.183.255'),
            array('4.244.0.121/15', '4.244.0.0', '4.245.255.255'),
            array('134.7.4.201/31', '134.7.4.200', '134.7.4.201'),
            array('8.134.218.219/16', '8.134.0.0', '8.134.255.255'),
            array('146.59.19.160/12', '146.48.0.0', '146.63.255.255'),
            array('140.103.12.209/9', '140.0.0.0', '140.127.255.255'),
        );
    }

    /**
     * @dataProvider cidrs
     */
    public function testFromString($string, $start, $end)
    {
        $cidrRange = Range::rangeFromCidr($string);
//        $this->assertEquals($string, (string) $cidrRange);
        $this->assertEquals($start, (string) $cidrRange->getStartIp());
        $this->assertEquals($end, (string) $cidrRange->getEndIp());
    }
}
