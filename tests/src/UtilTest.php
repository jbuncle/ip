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
 * Tests for Ip\Util.
 *
 * @author James Buncle <jbuncle@hotmail.com>
 */
class UtilTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Ip\Util::isIPv4
     */
    public function testIsIPv4()
    {
        $this->assertTrue(Util::isIPv4('0.0.0.0'));
        $this->assertTrue(Util::isIPv4('255.255.255.255'));

        $this->assertFalse(Util::isIPv4('-1.-1.-1.-1'));
        $this->assertFalse(Util::isIPv4('256.256.256.256'));
    }

    /**
     * @covers Ip\Util::isIPv6
     */
    public function testIsIPv6()
    {
        $this->assertTrue(Util::isIPv6('0:0:0:0:0:0:0:0'));
        $this->assertTrue(Util::isIPv6('FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF'));
        $this->assertTrue(Util::isIPv6('FFFD:FFFD:FFFD:FFFD:FFFD:FFFD:FFFD:FFFD'));

        $this->assertFalse(Util::isIPv6('0:0:0:0:0:0:0:-1'));
        $this->assertFalse(Util::isIPv6('0.0.0.0'));
        $this->assertFalse(Util::isIPv6('255.255.255.255'));
    }

    /**
     * @covers Ip\Util::ipv4ToFloat
     */
    public function testIpv4ToFloat()
    {
        $this->assertEquals(0, Util::ipv4ToFloat('0.0.0.0'));
        $this->assertEquals(4294967295, Util::ipv4ToFloat('255.255.255.255'));
    }
}
