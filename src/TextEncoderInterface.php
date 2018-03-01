<?php
/**
 * Copyright (c) 2004-2009, 2018 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2005-2010 Geoffrey Sneddon <http://gsnedders.com>
 * Copyright (c) 2004-2018 Contributors.
 *
 * https://opensource.org/licenses/BSD-3-Clause
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
     *
     * @return string
     */
    public static function detectEncoding(string $detect, ?array $encodingList = null): string;

    /**
     * Convert the string to UTF-8.
     *
     * @param string $string       The string to convert to UTF-8.
     * @param string $fromEncoding The current character encoding of the string.
     *
     * @return string
     */
    public static function toUtf8(string $string, string $fromEncoding): string;
}
