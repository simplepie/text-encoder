<?php
/**
 * Copyright (c) 2018-2019 Ryan Parman <http://ryanparman.com>
 * Copyright (c) 2018-2019 Contributors
 *
 * http://opensource.org/licenses/Apache2.0
 */

declare(strict_types=1);

namespace TextEncoder\Util;

/**
 * Normalize the names of the encodings to a simpler set.
 *
 * @see https://www.iana.org/assignments/character-sets/character-sets.xml
 */
class Encode
{
    /**
     * No construction of an instance. Static functions, only.
     */
    private function __construct()
    {
    }

    /**
     * Normalizes the name of the character encoding to a simpler set.
     *
     * @param string $charset The original name of the character encoding.
     *
     * @phpcs:disable Generic.Metrics.CyclomaticComplexity.MaxExceeded
     */
    public static function normalize(string $charset): string
    {
        // Normalization from UTS #22
        $cs = \mb_strtolower(\preg_replace('/(?:[^a-zA-Z0-9]+|([^0-9])0+)/', '\1', $charset));
    }

    // @phpcs:enable
}
