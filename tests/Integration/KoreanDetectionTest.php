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

class KoreanDetectionTest extends AbstractTestCase
{
    public function testEucKr(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/euc-kr.txt');

        $this->assertEquals(
            Encoding::EUC_KR,
            TextEncoder::detectEncoding(
                $data,
                Locale::asKorean()
            )
        );
    }

    public function testIso2022Kr(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/iso-2022-kr.txt');

        // Even though the text is encoded as ISO-2022-KR, PHP appears to detect
        // it as EUC-KR due to their ordering. EUC-KR is the most popular
        // non-Unicode encoding in Korean software, therefore it receives first
        // position.
        $this->assertEquals(
            Encoding::EUC_KR,
            TextEncoder::detectEncoding(
                $data,
                Locale::asKorean()
            )
        );
    }

    public function testKoreanMac(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/korean-mac.txt');

        $this->assertEquals(
            Encoding::EUC_KR,
            TextEncoder::detectEncoding(
                $data,
                Locale::asKorean()
            )
        );
    }

    public function testKoreanWindows(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/korean-win.txt');

        $this->assertEquals(
            Encoding::EUC_KR,
            TextEncoder::detectEncoding(
                $data,
                Locale::asKorean()
            )
        );
    }
}
