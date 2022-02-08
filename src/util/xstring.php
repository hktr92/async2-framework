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

use Stringable;
use Symfony\Component\String\UnicodeString;

use function Symfony\Component\String\u;

final class xstring implements Stringable
{
    private readonly UnicodeString $string;

    public function __construct(string|UnicodeString $str)
    {
        $this->string = $str instanceof UnicodeString ? $str : u($str);
    }

    public function ends_with(string $suffix): bool
    {
        return $this->string->endsWith($suffix);
    }

    public function lower(): self
    {
        return new self($this->string->lower());
    }

    public function empty(): bool
    {
        return $this->string->isEmpty();
    }

    public function to_str(): string
    {
        return $this->string->toString();
    }

    public function __toString(): string
    {
        return $this->to_str();
    }
}
