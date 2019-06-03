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

class JapaneseDetectionTest extends AbstractTestCase
{
    public function testEucJp(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/euc-jp.txt');

        static::assertEquals(
            Encoding::EUC_JP,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );
    }

    public function testIso2022Jp(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/iso-2022-jp.txt');

        static::assertEquals(
            Encoding::ISO_2022_JP,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );
    }

    public function testSjisMac(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/sjis-mac.txt');

        static::assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );
    }

    public function testSjisWindows(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/sjis-win.txt');

        static::assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );
    }

    public function testShiftJis(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/shift-jis.txt');

        static::assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );
    }
}
