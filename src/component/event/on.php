<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\event;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_ALL)]
final class on
{
    public function __construct(
        public readonly mixed $name,
        public readonly int $priority = 10,
    ) {
    }
}