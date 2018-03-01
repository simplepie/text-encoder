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

class JapaneseDetectionTest extends AbstractTestCase
{
    public function testEucJp(): void
    {
        $data = file_get_contents(__DIR__ . '/data/euc-jp.txt');

        // We should properly detect this as EUC-JP because we have fewer
        // encodings to deal with in the asJapanese() definition.
        $this->assertEquals(
            Encoding::EUC_JP,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );

        // We will get this wrong (as SJIS) because of how similar these are
        // with GB18030, and how we need to mess with the order to get it to
        // detect (mostly) right. Since we were going to be wrong, we might as
        // well get the right language.
        $this->assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data
            )
        );
    }

    public function testIso2022Jp(): void
    {
        $data = file_get_contents(__DIR__ . '/data/iso-2022-jp.txt');

        // We should properly detect this as ISO-2022-JP because we have fewer
        // encodings to deal with in the asJapanese() definition.
        $this->assertEquals(
            Encoding::ISO_2022_JP,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );

        $this->assertEquals(
            Encoding::ISO_2022_JP,
            TextEncoder::detectEncoding(
                $data
            )
        );
    }

    public function testSjisMac(): void
    {
        $data = file_get_contents(__DIR__ . '/data/sjis-mac.txt');

        $this->assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );

        $this->assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data
            )
        );
    }

    public function testSjisWindows(): void
    {
        $data = file_get_contents(__DIR__ . '/data/sjis-win.txt');

        $this->assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );

        $this->assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data
            )
        );
    }

    public function testShiftJis(): void
    {
        $data = file_get_contents(__DIR__ . '/data/shift-jis.txt');

        $this->assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data,
                Locale::asJapanese()
            )
        );

        $this->assertEquals(
            Encoding::SJIS,
            TextEncoder::detectEncoding(
                $data
            )
        );
    }
}
