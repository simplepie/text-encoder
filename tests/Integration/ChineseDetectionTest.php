<?php
/**
 * Copyright (c) 2018-2019 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2018-2019 Contributors
 *
 * http://opensource.org/licenses/Apache2.0
 */

declare(strict_types=1);

namespace TextEncoder\Test\Integration;

use TextEncoder\Enum\Encoding;
use TextEncoder\TextEncoder;
use TextEncoder\Util\Locale;

class ChineseDetectionTest extends AbstractTestCase
{
    public function testGb18030(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/gb-18030.txt');

        // All of the GB* Chinese encodings appear to be subsets of GB18030.
        static::assertEquals(
            Encoding::GB18030,
            TextEncoder::detectEncoding(
                $data,
                Locale::asChinese()
            )
        );
    }

    public function testGb2312(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/gb-2312.txt');

        // All of the GB* Chinese encodings appear to be subsets of GB18030.
        static::assertEquals(
            Encoding::GB18030,
            TextEncoder::detectEncoding(
                $data,
                Locale::asChinese()
            )
        );
    }

    public function testGbk(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/gbk.txt');

        // All of the GB* Chinese encodings appear to be subsets of GB18030.
        static::assertEquals(
            Encoding::GB18030,
            TextEncoder::detectEncoding(
                $data,
                Locale::asChinese()
            )
        );
    }
}
