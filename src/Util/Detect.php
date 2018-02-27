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

class Detect
{
    private function __construct()
    {
    }

    /**
     * Detect XML encoding, as per XML 1.0 Appendix F.1.
     *
     * @param string $data The XML data to parse.
     *
     * @return array List of possible encodings.
     *
     * @todo Add support for EBCDIC
     *
     * @phpcs:disable Generic.Files.LineLength.MaxExceeded
     * @phpcs:disable Generic.Metrics.CyclomaticComplexity.MaxExceeded
     */
    public static function xmlEncoding($data)
    {
        if ("\x00\x00\xFE\xFF" === \mb_substr($data, 0, 4)) {
            $encoding[] = 'UTF-32BE';
        } elseif ("\xFF\xFE\x00\x00" === \mb_substr($data, 0, 4)) {
            $encoding[] = 'UTF-32LE';
        } elseif ("\xFE\xFF" === \mb_substr($data, 0, 2)) {
            $encoding[] = 'UTF-16BE';
        } elseif ("\xFF\xFE" === \mb_substr($data, 0, 2)) {
            $encoding[] = 'UTF-16LE';
        } elseif ("\xEF\xBB\xBF" === \mb_substr($data, 0, 3)) {
            $encoding[] = 'UTF-8';
        } elseif ("\x00\x00\x00\x3C\x00\x00\x00\x3F\x00\x00\x00\x78\x00\x00\x00\x6D\x00\x00\x00\x6C" === \mb_substr($data, 0, 20)) {
            $pos = \mb_strpos($data, "\x00\x00\x00\x3F\x00\x00\x00\x3E");

            if ($pos) {
                $parser = new XML_Declaration_Parser(
                    Convert::convertEncoding(\mb_substr($data, 20, $pos - 20), 'UTF-32BE', 'UTF-8')
                );

                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }

            $encoding[] = 'UTF-32BE';
        } elseif ("\x3C\x00\x00\x00\x3F\x00\x00\x00\x78\x00\x00\x00\x6D\x00\x00\x00\x6C\x00\x00\x00" === \mb_substr($data, 0, 20)) {
            $pos = \mb_strpos($data, "\x3F\x00\x00\x00\x3E\x00\x00\x00");

            if ($pos) {
                $parser = new XML_Declaration_Parser(
                    Convert::convertEncoding(\mb_substr($data, 20, $pos - 20), 'UTF-32LE', 'UTF-8')
                );

                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }

            $encoding[] = 'UTF-32LE';
        } elseif ("\x00\x3C\x00\x3F\x00\x78\x00\x6D\x00\x6C" === \mb_substr($data, 0, 10)) {
            $pos = \mb_strpos($data, "\x00\x3F\x00\x3E");

            if ($pos) {
                $parser = new XML_Declaration_Parser(
                    Convert::convertEncoding(\mb_substr($data, 20, $pos - 10), 'UTF-16BE', 'UTF-8')
                );

                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }

            $encoding[] = 'UTF-16BE';
        } elseif ("\x3C\x00\x3F\x00\x78\x00\x6D\x00\x6C\x00" === \mb_substr($data, 0, 10)) {
            $pos = \mb_strpos($data, "\x3F\x00\x3E\x00");

            if ($pos) {
                $parser = new XML_Declaration_Parser(
                    Convert::convertEncoding(\mb_substr($data, 20, $pos - 10), 'UTF-16LE', 'UTF-8')
                );

                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }

            $encoding[] = 'UTF-16LE';
        } elseif ("\x3C\x3F\x78\x6D\x6C" === \mb_substr($data, 0, 5)) {
            $pos = \mb_strpos($data, "\x3F\x3E");

            if ($pos) {
                $parser = new XML_Declaration_Parser(
                    Convert::convertEncoding(\mb_substr($data, 5, $pos - 5))
                );

                if ($parser->parse()) {
                    $encoding[] = $parser->encoding;
                }
            }

            $encoding[] = 'UTF-8';
        } else {
            // Fallback to UTF-8
            $encoding[] = 'UTF-8';
        }

        return $encoding;
    }

    // @phpcs:enable
}
