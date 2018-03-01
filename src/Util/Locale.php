<?php
/**
 * Copyright (c) 2004-2009, 2018 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2005-2010 Geoffrey Sneddon <http://gsnedders.com>
 * Copyright (c) 2004-2018 Contributors.
 *
 * https://opensource.org/licenses/BSD-3-Clause
 */

declare(strict_types=1);

namespace TextEncoder\Util;

use TextEncoder\Enum\Encoding;

class Locale
{
    private function __construct()
    {
    }

    /**
     * These are the standard Unicode family of encodings that are supported.
     *
     * @return array
     */
    public static function asUnicode(): array
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
        ];
    }

    /**
     * These are the most common non-Unicode Japanese character encodings.
     *
     * @return array
     */
    public static function asJapanese(): array
    {
        return \array_merge(
            [
                Encoding::ISO_2022_JP,
                Encoding::CP50222,
                Encoding::CP50221,
                Encoding::CP50220,
                Encoding::CP50220RAW,
            ],
            self::asUnicode(),
            [
                Encoding::EUC_JP,
                Encoding::CP51932,
                Encoding::SJIS,
                Encoding::JIS,
                Encoding::JIS_MS,
                Encoding::CP932,
            ]
        );
    }

    /**
     * These are the most common non-Unicode character encodings for
     * The People's Republic of China (PRC; Mainland China).
     *
     * @return array
     */
    public static function asSimplifiedChinese(): array
    {
        return \array_merge(
            self::asUnicode(),
            [
                Encoding::GB18030, // CP54936
                Encoding::EUC_CN,  // GBK
                Encoding::CP936,   // GB2312
                Encoding::HZ,
            ]
        );
    }

    /**
     * These are the most common non-Unicode character encodings for
     * The Republic of China (ROC; Taiwan).
     *
     * @return array
     */
    public static function asTraditionalChinese(): array
    {
        return \array_merge(
            self::asUnicode(),
            [
                Encoding::BIG_5,
                Encoding::CP950,
                Encoding::EUC_TW,
            ]
        );
    }

    /**
     * These are a blend of both Simplified and Traditional Chinese encodings.
     * The Simplified is first and Traditional is second, only because of the
     * worldwide number of users.
     *
     * @return array
     */
    public static function asChinese(): array
    {
        return \array_unique(
            \array_merge(
                self::asSimplifiedChinese(),
                self::asTraditionalChinese()
            )
        );
    }

    /**
     * These are the most common non-Unicode character encodings for
     * North and South Korea. More often, ISO-2022-KR will be selected
     * over EUC-KR.
     *
     * @return array
     */
    public static function asKorean(): array
    {
        return \array_merge(
            [
                Encoding::EUC_KR,
                Encoding::UHC,
                Encoding::ISO_2022_KR,
            ],
            self::asUnicode()
        );
    }
}






// Encoding::CP866, // Russian
// Encoding::CP850, // Windows-1252
