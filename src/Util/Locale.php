<?php
/**
 * Copyright (c) 2018-2019 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2018-2019 Contributors
 *
 * http://opensource.org/licenses/Apache2.0
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

    /**
     * These are the most common non-Unicode character encodings for
     * North and South Korea. More often, ISO-2022-KR will be selected
     * over EUC-KR.
     */
    public static function asIso8859(): array
    {
        return \array_merge(
            self::asUnicode(),
            [
                Encoding::ISO_8859_16,
                Encoding::WINDOWS_1252,
                Encoding::CP850,
                Encoding::ISO_8859_15,
                Encoding::ISO_8859_14,
                Encoding::WINDOWS_1257,
                Encoding::ISO_8859_13,
                Encoding::ISO_8859_11,
                Encoding::ISO_8859_10,
                Encoding::WINDOWS_1254,
                Encoding::ISO_8859_9,
                Encoding::WINDOWS_1255,
                Encoding::ISO_8859_8,
                Encoding::WINDOWS_1253,
                Encoding::ISO_8859_7,
                Encoding::WINDOWS_1256,
                Encoding::ISO_8859_6,
                Encoding::WINDOWS_1251,
                Encoding::ISO_8859_5,
                Encoding::ISO_8859_4,
                Encoding::ISO_8859_3,
                Encoding::WINDOWS_1250,
                Encoding::ISO_8859_2,
                Encoding::ISO_8859_1,
                Encoding::WINDOWS_1258,
            ]
        );
    }
}

// Encoding::CP866, // Russian
