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

use PHPUnit_Framework_TestCase;

/**
 * Tests for Ip\v6\Address.
 *
 * @author James Buncle <jbuncle@hotmail.com>
 */
class AddressTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test creation from shorthand IP adddress.
     */
    public function testCreateFromShorthand()
    {
        $shorthandIp = 'FFFF:::::::FFFF';

        $this->assertEquals($shorthandIp, (string) Address::fromString($shorthandIp));
    }

    /**
     * Test __toString method.
     *
     * @covers Ip\v6\Address::__toString
     */
    public function testToString()
    {
        $ip = 'FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF';
        $ipObj = Address::fromString($ip);
        $this->assertEquals($ip, (string) $ipObj);
    }

    public function compareToDataProvider()
    {
        return array(
            array('FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFE', 'FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF', -1),
            array('FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF', 'FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFE', 1),
            array('FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF', 'FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF', 0),
            array(':::::::1', ':::::::1', 0),
            array(':::::::1', ':::::::0', 1),
            array(':::::::0', ':::::::1', -1),
        );
    }

    /**
     * Test compareTo method where this is less than given.
     *
     * @covers Ip\v6\Address::compareTo
     *
     * @dataProvider compareToDataProvider
     */
    public function testCompareTo($a, $b, $expected)
    {
        $ipA = Address::fromString($a);
        $ipB = Address::fromString($b);
        $this->assertEquals($expected, $ipA->compareTo($ipB));
    }
}
