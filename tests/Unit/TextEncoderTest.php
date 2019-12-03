<?php
/**
 * Copyright (c) 2018-2019 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2018-2019 Contributors
 *
 * http://opensource.org/licenses/Apache2.0
 */

declare(strict_types=1);

namespace TextEncoder\Test\Unit;

use TextEncoder\TextEncoder;

class TextEncoderTest extends AbstractTestCase
{
    public function testDetectEncoding()
    {
        TextEncoder::detectEncoding(string $detect, ?array $encodingList = null): string
    }
}
