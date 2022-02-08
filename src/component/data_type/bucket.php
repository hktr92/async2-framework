<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\data_type;

use async2\util\data_mapper;
use async2\util\xstring;

use function array_map;

/**
 * @package async2
 *
 * class that contains a simple dictionary of string type for both keys and values.
 *
 * @psalm-type _mixed_val null|bool|int|float|string
 */
final class bucket
{
    /**
     * helper method that allows creation of a bucket from mixed array values.
     *
     * @psalm-param array<string, mixed> $items
     */
    public static function from(array $items): self
    {
        return new self(array_map(fn($val) => /** @psalm-var _mixed_val $val */ data_mapper::to_string($val), $items));
    }

    /**
     * @psalm-param array<string, null|xstring> $items
     */
    public function __construct(
        private readonly array $items = [],
    ) {
    }

    /**
     * returns a stored value by key, or a default string value.
     */
    public function get(string $key, string $default = ''): xstring
    {
        $default = new xstring($default);

        return $this->items[$key] ?? $default;
    }
}
