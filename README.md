# PHP IP

[![Build Status](https://travis-ci.org/jbuncle/ip.svg?branch=master)](https://travis-ci.org/jbuncle/ip)
[![codecov.io](https://codecov.io/github/jbuncle/ip/coverage.svg?branch=master)](https://codecov.io/github/jbuncle/ip?branch=master)
[![codacy.com](https://api.codacy.com/project/badge/)](https://www.codacy.com/public/jbuncle/ip.git)

Simple library for working with IP addresses and ranges in PHP 5.3+.

## Composer Installation
Run `php composer.phar require jbuncle/ip`

## Usage

### IPv4
```php
use Ip\v4\Range;
use Ip\v4\Address;

$range = Range::fromStrings('207.15.124.153', '207.15.124.163');
$inRange = $range->isInRange(Address::fromString('207.15.124.153'));

var_export($inRange); // Prints 'true'
```

### IPv6
```php
use Ip\v6\Range;
use Ip\v6\Address;

$range = Range::fromStrings('0:0:0:0:0:0:0:0', 'F:F:F:F:F:F:F:F');
$inRange = $range->isInRange(Address::fromString('1:1:1:1:1:1:1:1'));

var_export($inRange); // Prints 'true'
```


## Contributing
* This project adheres to the PSR-2 standards. Please make sure your contributions comply.
* Make sure to document your code with the PHPDoc syntax
* Pull Requests and Issues should contain no more than 1 bug-fix, feature, or documentation change

## Licence
The MIT License

Copyright 2016 James Buncle <jbuncle@hotmail.com>.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.