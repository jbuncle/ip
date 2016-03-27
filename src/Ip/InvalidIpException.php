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
 * InvalidIpException
 *
 * @author James Buncle <jbuncle@hotmail.com>
 */
class InvalidIpException extends IpException
{

    /**
     * Value given that was considered invalid.
     *
     * @var mixed
     */
    private $ip;

    /**
     * Construct the exception.
     *
     * @param type $ip
     *
     * @param string $message [optional] The Exception message to throw.
     * @param IpException $previous [optional] The previous exception used for the exception chaining.
     */
    public function __construct($ip, $message = "", \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->ip = $ip;
    }

    /**
     * Get the associated invalid IP.
     *
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }
}
