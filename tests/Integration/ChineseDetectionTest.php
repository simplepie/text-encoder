<?php
/**
 * Copyright (c) 2004-2009, 2018 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2005-2010 Geoffrey Sneddon <http://gsnedders.com>
 * Copyright (c) 2004-2018 Contributors.
 *
 * https://opensource.org/licenses/BSD-3-Clause
 */

declare(strict_types=1);

namespace TextEncoder\Test\Integration;

use TextEncoder\TextEncoder;
use TextEncoder\Enum\Encoding;
use TextEncoder\Util\Detect;
use TextEncoder\Util\Encode;
use TextEncoder\Util\Locale;

class ChineseDetectionTest extends AbstractTestCase
{
    public function testGb18030(): void
    {
        $data = file_get_contents(__DIR__ . '/data/gb-18030.txt');

        // All of the GB* Chinese encodings appear to be subsets of GB18030.
        $this->assertEquals(
            Encoding::GB18030,
            TextEncoder::detectEncoding(
                $data,
                Locale::asChinese()
            )
        );

        $this->assertEquals(
            Encoding::GB18030,
            TextEncoder::detectEncoding(
                $data
            )
        );
    }

    public function testGb2312(): void
    {
        $data = file_get_contents(__DIR__ . '/data/gb-2312.txt');

        // All of the GB* Chinese encodings appear to be subsets of GB18030.
        $this->assertEquals(
            Encoding::GB18030,
            TextEncoder::detectEncoding(
                $data,
                Locale::asChinese()
            )
        );

        $this->assertEquals(
            Encoding::GB18030,
            TextEncoder::detectEncoding(
                $data
            )
        );
    }

    public function testGbk(): void
    {
        $data = file_get_contents(__DIR__ . '/data/gbk.txt');

        // All of the GB* Chinese encodings appear to be subsets of GB18030.
        $this->assertEquals(
            Encoding::GB18030,
            TextEncoder::detectEncoding(
                $data,
                Locale::asChinese()
            )
        );

        $this->assertEquals(
            Encoding::GB18030,
            TextEncoder::detectEncoding(
                $data
            )
        );
    }
}
