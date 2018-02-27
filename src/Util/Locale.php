<?php
/**
 * Copyright (c) 2018 Ryan Parman <http://ryanparman.com>.
 * Copyright (c) 2018 Contributors.
 *
 * http://opensource.org/licenses/Apache2.0
 */

declare(strict_types=1);

namespace TextEncoder\Util;

use Convert;
use TextEncoder\Enum\Encoding;

class Locale
{
    private function __construct()
    {
    }

    public static function asJapanese(): array
    {
        return [
            Encoding::ISO_2022_JP,
            Encoding::UCS4,
            Encoding::UCS4_BE,
            Encoding::UCS4_LE,
            Encoding::UCS2,
            Encoding::UCS2_BE,
            Encoding::UCS2_LE,
            Encoding::UTF32,
            Encoding::UTF32_BE,
            Encoding::UTF32_LE,
            Encoding::UTF16,
            Encoding::UTF16_BE,
            Encoding::UTF16_LE,
            Encoding::UTF8,
            Encoding::EUC_JP,
            Encoding::SJIS,
            Encoding::JIS,
            Encoding::JIS_MS,
        ];
    }

    public static function asChinese(): array
    {
        return [
            Encoding::UCS4,
            Encoding::UCS4_BE,
            Encoding::UCS4_LE,
            Encoding::UCS2,
            Encoding::UCS2_BE,
            Encoding::UCS2_LE,
            Encoding::UTF32,
            Encoding::UTF32_BE,
            Encoding::UTF32_LE,
            Encoding::UTF16,
            Encoding::UTF16_BE,
            Encoding::UTF16_LE,
            Encoding::UTF8,
            Encoding::GB18030,
            Encoding::EUC_CN,
            Encoding::CP936,
            Encoding::HZ,
            Encoding::EUC_TW,
            Encoding::BIG_5,
        ];
    }
}
