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

use ReflectionClass;

/**
 * The base enum class that all other enum classes extend from. It does the
 * heavy lifting of implementing `EnumInterface` so that extending enum classes
 * can focus on defining enums.
 */
abstract class AbstractEnum implements EnumInterface
{
    /**
     * {@inheritdoc}
     */
    public static function introspect(): array
    {
        $refl = new ReflectionClass(\get_called_class());

        return $refl->getConstants();
    }

    /**
     * {@inheritdoc}
     */
    public static function introspectKeys(): array
    {
        return \array_keys(static::introspect());
    }

    /**
     * {@inheritdoc}
     */
    public static function hasValue(string $value): bool
    {
        $arr = \array_flip(static::introspect());

        return isset($arr[$value]);
    }
}
