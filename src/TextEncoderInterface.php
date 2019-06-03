<?php
/**
 * Copyright (c) 2018-2019 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2018-2019 Contributors
 *
 * http://opensource.org/licenses/Apache2.0
 */

declare(strict_types=1);

namespace TextEncoder;

use TextEncoder\Enum\Encoding;
use TextEncoder\Util\Convert;

interface TextEncoderInterface
{
    /**
     * Detect the current current character encoding of a string.
     *
     * @param string     $detect       The string with which to detect the character encoding.
     * @param array|null $encodingList The list of encodings to compare against. If set to `null`, a default function
     *                                 will be used to produce a comparison list. The default value is `null`.
     */
    public static function detectEncoding(string $detect, ?array $encodingList = null): string;

    /**
     * Convert the string to UTF-8.
     *
     * @param string $string       The string to convert to UTF-8.
     * @param string $fromEncoding The current character encoding of the string.
     */
    public static function toUtf8(string $string, string $fromEncoding): string;
}
