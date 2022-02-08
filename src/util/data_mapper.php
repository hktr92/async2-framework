<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\util;

use async2\framework\exception;

use function get_debug_type;

/**
 * @package async2
 *
 * @psalm-type _mixed_val null|bool|int|float|string
 */
final class data_mapper
{
    /**
     * a simple data mapper between various types to string.
     *
     * @psalm-param _mixed_val $value
     */
    public static function to_str($value): string
    {
        return match ($type = get_debug_type($value)) {
            "null" => '',
            "bool" => self::to_str($value ? 1 : 0),
            "int", "float", "string" => (string)$value,
            default => throw new exception("unable to map to 'string' value of $type.")
        };
    }

    /**
     * @psalm-param _mixed_val $value
     */
    public static function to_string($value): xstring
    {
        return new xstring(self::to_str($value));
    }
}
