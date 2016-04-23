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
 * Tests for Ip\v4\Address.
 *
 * @author James Buncle <jbuncle@hotmail.com>
 */
class AddressTest extends PHPUnit_Framework_TestCase
{

    public function testGetBroadcast()
    {
        // Remove the following lines when you implement this test.
        $this->assertEquals('255.255.255.255', (string) Address::getBroadcast());
    }

    public function validIps()
    {
        return array(
            array(3438672611, '204.245.250.227'),
            array(1321469601, '78.196.6.161'),
            array(2246267907, '133.227.84.3'),
            array(824855399, '49.42.75.103'),
            array(3492879827, '208.49.29.211'),
            array(3142457325, '187.78.23.237'),
            array(1805799231, '107.162.79.63'),
            array(3830403948, '228.79.83.108'),
            array(2073969294, '123.158.66.142'),
            array(1760305326, '104.236.32.174'),
            array(4294967295, '255.255.255.255'),
            array(0, '0.0.0.0'),
        );
    }

    public function invalidDataProvider()
    {
        return array(
            array('0,0,0,0'),
            array('256.256.256.256'),
            array('0.0.0.-1'),
            array('1.1.1'),
            array(4294967296),
            array(-1),
            array('a'),
            array('4294967296'),
            array('-1'),
            array(''),
            array(true),
            array(false),
            array(array(null)),
            array(array('')),
            array(null),
        );
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testFromFloatInvalid($invalidFloat)
    {
        $this->setExpectedException('Ip\InvalidIpException');
        Address::fromFloat($invalidFloat);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testFromStringInvalid($invalidFloat)
    {
        $this->setExpectedException('Ip\InvalidIpException');
        Address::fromString($invalidFloat);
    }

    public function testFromArrayInvalid()
    {
        $this->setExpectedException('Ip\InvalidIpException');
        Address::fromArray(array(null));
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testFromValueInvalid($invalidFloat)
    {
        $this->setExpectedException('Ip\InvalidIpException');
        Address::fromValue($invalidFloat);
    }

    /**
     * @dataProvider validIps
     */
    public function testFromFloat($float, $expected)
    {
        $ip = Address::fromFloat($float);
        $this->assertEquals($expected, (string) $ip);
    }

    /**
     * @dataProvider validIps
     */
    public function testFromStringToFloat($long, $string)
    {
        $ip = Address::fromString($string);
        $this->assertEquals($long, $ip->asLong());
    }

    /**
     * @dataProvider validIps
     */
    public function testFromValue($long, $string)
    {
        $this->assertEquals($string, (string) Address::fromValue($string));
        $this->assertEquals($string, (string) Address::fromValue($long));
    }

    /**
     * @dataProvider validIps
     */
    public function testFromStringToString($long, $string)
    {
        $ip = Address::fromString($string);
        $this->assertEquals($string, (string) $ip);
    }
}
