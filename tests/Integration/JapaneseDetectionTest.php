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

use TextEncoder\Enum\Encoding;
use TextEncoder\TextEncoder;
use TextEncoder\Util\Locale;

class JapaneseDetectionTest extends AbstractTestCase
{
    public function testEucJp(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/euc-jp.txt');

        $this->assertEquals(
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

        $this->assertEquals(
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

        $this->assertEquals(
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

        $this->assertEquals(
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

        $this->assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );
    }
}
