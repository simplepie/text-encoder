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

class KoreanDetectionTest extends AbstractTestCase
{
    public function testEucKr(): void
    {
        $data = \file_get_contents(__DIR__ . '/data/euc-kr.txt');

        static::assertEquals(
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
        static::assertEquals(
            Encoding::EUC_KR,
            TextEncoder::detectEncoding(
                $data,
                Locale::asKorean()
            )
        );
    }
}
