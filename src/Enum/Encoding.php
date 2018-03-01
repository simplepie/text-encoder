<?php
/**
 * Copyright (c) 2004-2009, 2018 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2005-2010 Geoffrey Sneddon <http://gsnedders.com>
 * Copyright (c) 2004-2018 Contributors.
 *
 * https://opensource.org/licenses/BSD-3-Clause
 */

declare(strict_types=1);

namespace TextEncoder\Enum;

class Encoding extends AbstractEnum
{
    /**
     * Legacy Armenian encoding. ISO-10585 is more common.
     */
    public const ARMSCII_8 = 'ArmSCII-8';

    /**
     * Another name for US-ASCII, developed by the ANSI group (not to be
     * confused with what Windows calls "ANSI", which is a misnomer for
     * Windows-1252).
     */
    public const ASCII = 'ASCII';

    /**
     * Big-5 is a Chinese character encoding method used in Taiwan, Hong Kong,
     * and Macau for Traditional Chinese characters.
     */
    public const BIG_5 = 'BIG-5';

    /**
     * Legacy Japanese encoding. ISO-2022-JP is more common.
     */
    public const CP50220 = 'CP50220';

    /**
     * Legacy Japanese encoding. ISO-2022-JP is more common.
     */
    public const CP50220RAW = 'CP50220raw';

    /**
     * Legacy Japanese encoding. ISO-2022-JP is more common.
     */
    public const CP50221 = 'CP50221';

    /**
     * Legacy Japanese encoding. ISO-2022-JP is more common.
     */
    public const CP50222 = 'CP50222';

    /**
     * Legacy Japanese encoding. EUC-JP is more common.
     */
    public const CP51932 = 'CP51932';

    /**
     * Alias for Windows-1252.
     */
    public const CP850 = 'CP850';

    /**
     * Legacy Cyrillic encoding. Windows-1251 is more common.
     */
    public const CP866 = 'CP866';

    /**
     * Legacy Japanese encoding. Shift-JIS is more common.
     */
    public const CP932 = 'CP932';

    /**
     * Legacy Simplified Chinese encoding. GB18030 is more common.
     */
    public const CP936 = 'CP936';

    /**
     * Alias for Big-5.
     */
    public const CP950 = 'CP950';

    /**
     * Legacy Simplified Chinese encoding with ASCII-compatibility.
     * GB18030 is more common.
     */
    public const EUC_CN = 'EUC-CN';

    /**
     * EUC-JP is heavily used by Unix or Unix-like operating systems, while
     * Shift-JIS is used on other platforms. Therefore, whether Japanese web
     * sites use EUC-JP or Shift_JIS often depends on what OS the author uses.
     */
    public const EUC_JP = 'EUC-JP';

    /**
     * EUC-KR is the most common non-Unicode encoding in Korean software.
     */
    public const EUC_KR = 'EUC-KR';

    /**
     * Legacy Traditional Chinese encoding. Big-5 is more common.
     */
    public const EUC_TW = 'EUC-TW';

    /**
     * GB18030 is a Chinese character encoding method used in Mainland China
     * for Simplified Chinese characters.
     */
    public const GB18030 = 'GB18030';

    /**
     * Legacy Simplified Chinese encoding with ASCII-compatibility.
     * GB18030 is more common.
     */
    public const HZ = 'HZ';

    /**
     * A Japanese encoding. Popularity is unknown.
     */
    public const ISO_2022_JP = 'ISO-2022-JP';

    /**
     * A Korean encoding. Popularity is unknown.
     */
    public const ISO_2022_KR = 'ISO-2022-KR';

    /**
     * A legacy Western European (including North and South America, Australia,
     * New Zealand, etc.) encoding sometimes known as "Latin-1". In most
     * real-world software and the WHATWG Encoding specification, this is
     * superceded by Windows-1252.
     */
    public const ISO_8859_1 = 'ISO-8859-1';

    /**
     * A legacy Central/Eastern European (Albanian, Bosnian, Croatian, Czech,
     * German, Hungarian, Polish, Romanian, Serbian Latin, Slovak, Slovene,
     * Upper Sorbian, Lower Sorbian, Turkmen) encoding sometimes known as
     * "Latin-2". Similar, but not identical to, Windows-1250.
     */
    public const ISO_8859_2 = 'ISO-8859-2';

    /**
     * A Southern European (Turkish, Maltese, Esperanto) encoding sometimes
     * known as "Latin-3". ISO-8859-9 is more commonly used for Turkish.
     */
    public const ISO_8859_3 = 'ISO-8859-3';

    /**
     * A legacy Northern European (Estonian, Latvian, Lithuanian, Greenlandic,
     * Sami) encoding sometimes known as "Latin-4". It has largely been replaced
     * with ISO-8859-10 and UTF-8.
     */
    public const ISO_8859_4 = 'ISO-8859-4';

    /**
     * A legacy Latin/Cyrillic (Bulgarian, Belarusian, Russian, Serbian,
     * Macedonian, Ukranian) encoding. It was never widely used, and KOI8-R,
     * KOI8-U, CP866, Windows-1251, and UTF-8 are more common.
     */
    public const ISO_8859_5 = 'ISO-8859-5';

    /**
     * A Latin/Arabic encoding, and is a bi-directional character set.
     */
    public const ISO_8859_6 = 'ISO-8859-6';

    /**
     * A Latin/Greek encoding.
     */
    public const ISO_8859_7 = 'ISO-8859-7';

    /**
     * A Latin/Hebrew encoding. It covers all Hebrew letters, but no Hebrew
     * vowel signs.
     */
    public const ISO_8859_8 = 'ISO-8859-8';

    /**
     * A Turkish encoding, sometimes known as "Latin-5". It is an update of
     * ISO-8859-5 for the Turkish language.
     */
    public const ISO_8859_9 = 'ISO-8859-9';

    /**
     * A Nordic encoding, sometimes known as "Latin-6". It is an update of
     * ISO-8859-4 for the Turkish language.
     */
    public const ISO_8859_10 = 'ISO-8859-10';

    /**
     * A Latin/Thai encoding. Unofficial.
     */
    public const ISO_8859_11 = 'ISO-8859-11';

    /**
     * A Baltic Rim (Lithuanian, Latvian, Polish) encoding sometimes known as
     * "Latin-7".
     */
    public const ISO_8859_13 = 'ISO-8859-13';

    /**
     * A Celtic (Irish, Manx, Scottish Gaelic, Welsh, Cornish, Breton) encoding
     * sometimes known as "Latin-8".
     */
    public const ISO_8859_14 = 'ISO-8859-14';

    /**
     * An update to ISO-8859-1 which includes the Euro symbol. In most
     * real-world software and the WHATWG Encoding specification, this is
     * superceded by Windows-1252.
     */
    public const ISO_8859_15 = 'ISO-8859-15';

    /**
     * A South-Eastern European (Albanian, Croatian, Hungarian, Polish,
     * Romanian, Serbian, Slovenian, French, German, Italian, Irish Gaelic)
     * encoding.
     */
    public const ISO_8859_16 = 'ISO-8859-16';

    /**
     * Legacy Japanese encoding. Shift-JIS is more common.
     */
    public const JIS = 'JIS';

    /**
     * Legacy Japanese encoding. Shift-JIS is more common.
     */
    public const JIS_MS = 'JIS-ms';

    public const KOI8_R = 'KOI8-R';

    public const KOI8_U = 'KOI8-U';

    /**
     * EUC-JP is heavily used by Unix or Unix-like operating systems, while
     * Shift-JIS is used on other platforms. Therefore, whether Japanese web
     * sites use EUC-JP or Shift_JIS often depends on what OS the author uses.
     */
    public const SJIS = 'SJIS';

    public const UCS2 = 'UCS-2';

    public const UCS2_BE = 'UCS-2BE';

    public const UCS2_LE = 'UCS-2LE';

    public const UCS4 = 'UCS-4';

    public const UCS4_BE = 'UCS-4BE';

    public const UCS4_LE = 'UCS-4LE';

    /**
     * A superset of EUC-KR.
     */
    public const UHC = 'UHC';

    public const UTF16 = 'UTF-16';

    public const UTF16_BE = 'UTF-16BE';

    public const UTF16_LE = 'UTF-16LE';

    public const UTF32 = 'UTF-32';

    public const UTF32_BE = 'UTF-32BE';

    public const UTF32_LE = 'UTF-32LE';

    public const UTF7 = 'UTF-7';

    public const UTF7_IMAP = 'UTF7-IMAP';

    public const UTF8 = 'UTF-8';

    /**
     * An encoding nearly identical to ISO-8859-2.
     */
    public const WINDOWS_1250 = 'Windows-1250';

    /**
     * An encoding nearly identical to ISO-8859-5.
     */
    public const WINDOWS_1251 = 'Windows-1251';

    /**
     * In most real-world software and the WHATWG Encoding specification, this
     * is used instead of ISO-8859-1.
     */
    public const WINDOWS_1252 = 'Windows-1252';

    /**
     * An incompatible variant of ISO 8859-7.
     */
    public const WINDOWS_1253 = 'Windows-1253';

    /**
     * An encoding nearly identical to ISO-8859-9.
     */
    public const WINDOWS_1254 = 'Windows-1254';

    /**
     * An nearly-compatible encoding to ISO-8859-8.
     */
    public const WINDOWS_1255 = 'Windows-1255';

    /**
     * An incompatible variant of ISO-8859-6.
     */
    public const WINDOWS_1256 = 'Windows-1256';

    /**
     * An nearly-compatible encoding to ISO-8859-13.
     */
    public const WINDOWS_1257 = 'Windows-1257';

    /**
     * A Vietnamese encoding that is incompatible with VISCII.
     */
    public const WINDOWS_1258 = 'Windows-1258';
}
