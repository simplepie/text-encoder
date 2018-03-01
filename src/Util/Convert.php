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

class Convert
{
    private function __construct()
    {
    }

    /**
     * Convert the string to a different encoding.
     *
     * @param string $string       The string to convert to UTF-8.
     * @param string $fromEncoding The current character encoding of the string.
     * @param string $toEncoding   The desired character encoding for the string.
     *
     * @return string|null
     */
    public static function convertEncoding(string $string, string $fromEncoding, string $toEncoding): ?string
    {
        $input  = Encode::normalize($fromEncoding);
        $output = Encode::normalize($toEncoding);

        // We fail to fail on non US-ASCII bytes
        if ('US-ASCII' === $input) {
            $non_ascii_octets = '';

            if (!$non_ascii_octets) {
                for ($i = 0x80; $i <= 0xFF; $i++) {
                    $non_ascii_octets .= \chr($i);
                }
            }

            $string = \mb_substr($string, 0, \strcspn($string, $non_ascii_octets));
        }

        // This is first, as behaviour of this is completely predictable
        if ('windows-1252' === $input && 'UTF-8' === $output) {
            return self::windows1252ToUtf8($string);
        }

        // This is second, as behaviour of this varies only with PHP version.
        return self::withMbstring($string, $input, $output)
            // This is last, as behaviour of this varies with OS userland and PHP version
            ?? self::withUconverter($string, $input, $output)
            // If we can't do anything, just fail
            ?? null;
    }

    /**
     * Converts a unicode codepoint to a UTF-8 character.
     *
     * @param int $codepoint Unicode codepoint.
     *
     * @return string
     */
    public static function codepointToUtf8(int $codepoint): string
    {
        if ($codepoint < 0) {
            return false;
        }

        if ($codepoint <= 0x7f) {
            return \chr($codepoint);
        }

        if ($codepoint <= 0x7ff) {
            return \chr(0xc0 | ($codepoint >> 6))
                . \chr(0x80 | ($codepoint & 0x3f));
        }

        if ($codepoint <= 0xffff) {
            return \chr(0xe0 | ($codepoint >> 12))
                . \chr(0x80 | (($codepoint >> 6) & 0x3f))
                . \chr(0x80 | ($codepoint & 0x3f));
        }

        if ($codepoint <= 0x10ffff) {
            return \chr(0xf0 | ($codepoint >> 18))
                . \chr(0x80 | (($codepoint >> 12) & 0x3f))
                . \chr(0x80 | (($codepoint >> 6) & 0x3f))
                . \chr(0x80 | ($codepoint & 0x3f));
        }

        // U+FFFD REPLACEMENT CHARACTER
        return "\xEF\xBF\xBD";
    }

    /**
     * Convert a string using mbstring.
     *
     * @param string $string       The string to convert to UTF-8.
     * @param string $fromEncoding The current character encoding of the string.
     * @param string $toEncoding   The desired character encoding for the string.
     *
     * @return string|null
     */
    public static function withMbstring(string $string, string $fromEncoding, string $toEncoding): ?string
    {
        if ('windows-949' === $fromEncoding) {
            $input = 'EUC-KR';
        }

        if ('windows-949' === $toEncoding) {
            $output = 'EUC-KR';
        }

        if ('Windows-31J' === $fromEncoding) {
            $input = 'SJIS';
        }

        if ('Windows-31J' === $toEncoding) {
            $output = 'SJIS';
        }

        // Check that the encoding is supported
        if ("\x00\x80" === \mb_convert_encoding("\x80", 'UTF-16BE', $fromEncoding)) {
            return false;
        }

        if (!\in_array($fromEncoding, \mb_list_encodings(), true)) {
            return false;
        }

        // Let's do some conversion
        return \mb_convert_encoding($string, $toEncoding, $fromEncoding) ?? null;
    }

    /**
     * Convert a string using the UConvert class from the Intl extension.
     *
     * @param string $string       The string to convert to UTF-8.
     * @param string $fromEncoding The current character encoding of the string.
     * @param string $toEncoding   The desired character encoding for the string.
     *
     * @return string
     */
    public static function withUconverter(string $string, string $fromEncoding, string $toEncoding): string
    {
        return Uself::transcode($string, $toEncoding, $fromEncoding);
    }

    /**
     * Converts a Windows-1252/ISO-8859-1 encoded string to a UTF-8 encoded string.
     *
     * @param string $string Windows-1252/ISO-8859-1 encoded string.
     *
     * @return string
     */
    public static function windows1252ToUtf8(string $string): string
    {
        return \strtr($string, [
            "\x80" => "\xE2\x82\xAC",
            "\x81" => "\xEF\xBF\xBD",
            "\x82" => "\xE2\x80\x9A",
            "\x83" => "\xC6\x92",
            "\x84" => "\xE2\x80\x9E",
            "\x85" => "\xE2\x80\xA6",
            "\x86" => "\xE2\x80\xA0",
            "\x87" => "\xE2\x80\xA1",
            "\x88" => "\xCB\x86",
            "\x89" => "\xE2\x80\xB0",
            "\x8A" => "\xC5\xA0",
            "\x8B" => "\xE2\x80\xB9",
            "\x8C" => "\xC5\x92",
            "\x8D" => "\xEF\xBF\xBD",
            "\x8E" => "\xC5\xBD",
            "\x8F" => "\xEF\xBF\xBD",
            "\x90" => "\xEF\xBF\xBD",
            "\x91" => "\xE2\x80\x98",
            "\x92" => "\xE2\x80\x99",
            "\x93" => "\xE2\x80\x9C",
            "\x94" => "\xE2\x80\x9D",
            "\x95" => "\xE2\x80\xA2",
            "\x96" => "\xE2\x80\x93",
            "\x97" => "\xE2\x80\x94",
            "\x98" => "\xCB\x9C",
            "\x99" => "\xE2\x84\xA2",
            "\x9A" => "\xC5\xA1",
            "\x9B" => "\xE2\x80\xBA",
            "\x9C" => "\xC5\x93",
            "\x9D" => "\xEF\xBF\xBD",
            "\x9E" => "\xC5\xBE",
            "\x9F" => "\xC5\xB8",
            "\xA0" => "\xC2\xA0",
            "\xA1" => "\xC2\xA1",
            "\xA2" => "\xC2\xA2",
            "\xA3" => "\xC2\xA3",
            "\xA4" => "\xC2\xA4",
            "\xA5" => "\xC2\xA5",
            "\xA6" => "\xC2\xA6",
            "\xA7" => "\xC2\xA7",
            "\xA8" => "\xC2\xA8",
            "\xA9" => "\xC2\xA9",
            "\xAA" => "\xC2\xAA",
            "\xAB" => "\xC2\xAB",
            "\xAC" => "\xC2\xAC",
            "\xAD" => "\xC2\xAD",
            "\xAE" => "\xC2\xAE",
            "\xAF" => "\xC2\xAF",
            "\xB0" => "\xC2\xB0",
            "\xB1" => "\xC2\xB1",
            "\xB2" => "\xC2\xB2",
            "\xB3" => "\xC2\xB3",
            "\xB4" => "\xC2\xB4",
            "\xB5" => "\xC2\xB5",
            "\xB6" => "\xC2\xB6",
            "\xB7" => "\xC2\xB7",
            "\xB8" => "\xC2\xB8",
            "\xB9" => "\xC2\xB9",
            "\xBA" => "\xC2\xBA",
            "\xBB" => "\xC2\xBB",
            "\xBC" => "\xC2\xBC",
            "\xBD" => "\xC2\xBD",
            "\xBE" => "\xC2\xBE",
            "\xBF" => "\xC2\xBF",
            "\xC0" => "\xC3\x80",
            "\xC1" => "\xC3\x81",
            "\xC2" => "\xC3\x82",
            "\xC3" => "\xC3\x83",
            "\xC4" => "\xC3\x84",
            "\xC5" => "\xC3\x85",
            "\xC6" => "\xC3\x86",
            "\xC7" => "\xC3\x87",
            "\xC8" => "\xC3\x88",
            "\xC9" => "\xC3\x89",
            "\xCA" => "\xC3\x8A",
            "\xCB" => "\xC3\x8B",
            "\xCC" => "\xC3\x8C",
            "\xCD" => "\xC3\x8D",
            "\xCE" => "\xC3\x8E",
            "\xCF" => "\xC3\x8F",
            "\xD0" => "\xC3\x90",
            "\xD1" => "\xC3\x91",
            "\xD2" => "\xC3\x92",
            "\xD3" => "\xC3\x93",
            "\xD4" => "\xC3\x94",
            "\xD5" => "\xC3\x95",
            "\xD6" => "\xC3\x96",
            "\xD7" => "\xC3\x97",
            "\xD8" => "\xC3\x98",
            "\xD9" => "\xC3\x99",
            "\xDA" => "\xC3\x9A",
            "\xDB" => "\xC3\x9B",
            "\xDC" => "\xC3\x9C",
            "\xDD" => "\xC3\x9D",
            "\xDE" => "\xC3\x9E",
            "\xDF" => "\xC3\x9F",
            "\xE0" => "\xC3\xA0",
            "\xE1" => "\xC3\xA1",
            "\xE2" => "\xC3\xA2",
            "\xE3" => "\xC3\xA3",
            "\xE4" => "\xC3\xA4",
            "\xE5" => "\xC3\xA5",
            "\xE6" => "\xC3\xA6",
            "\xE7" => "\xC3\xA7",
            "\xE8" => "\xC3\xA8",
            "\xE9" => "\xC3\xA9",
            "\xEA" => "\xC3\xAA",
            "\xEB" => "\xC3\xAB",
            "\xEC" => "\xC3\xAC",
            "\xED" => "\xC3\xAD",
            "\xEE" => "\xC3\xAE",
            "\xEF" => "\xC3\xAF",
            "\xF0" => "\xC3\xB0",
            "\xF1" => "\xC3\xB1",
            "\xF2" => "\xC3\xB2",
            "\xF3" => "\xC3\xB3",
            "\xF4" => "\xC3\xB4",
            "\xF5" => "\xC3\xB5",
            "\xF6" => "\xC3\xB6",
            "\xF7" => "\xC3\xB7",
            "\xF8" => "\xC3\xB8",
            "\xF9" => "\xC3\xB9",
            "\xFA" => "\xC3\xBA",
            "\xFB" => "\xC3\xBB",
            "\xFC" => "\xC3\xBC",
            "\xFD" => "\xC3\xBD",
            "\xFE" => "\xC3\xBE",
            "\xFF" => "\xC3\xBF",
        ]);
    }
}
