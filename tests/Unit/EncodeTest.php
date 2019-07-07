<?php
/**
 * Copyright (c) 2018-2019 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2018-2019 Contributors
 *
 * http://opensource.org/licenses/Apache2.0
 */

declare(strict_types=1);

namespace TextEncoder\Test\Unit\Util;

use TextEncoder\Test\Unit\AbstractTestCase;
use TextEncoder\Util\Encode;

class EncodeTest extends AbstractTestCase
{
    public function testLookup(): void
    {
        static::assertSame('US-ASCII', Encode::normalize('US-ASCII'));
        static::assertSame('windows-1252', Encode::normalize('latin1'));
        static::assertSame('Shift_JIS', Encode::normalize('Windows-31J'));
    }

    public function testFailed(): void
    {
        static::assertSame('x-user-defined', Encode::normalize('Something that doesn\'t exist'));
    }
}
