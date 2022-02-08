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

namespace async2\component\router;

use async2\component\http;
use async2\framework\exception;

use function sprintf;
use function strtoupper;

/**
 * @package async2
 */
final class router_exception extends exception
{
    public static function route_already_defined(http\method $method, string $path): self
    {
        return new self(
            message: sprintf(
                "route already defined for %s %s",
                strtoupper($method->value),
                $path,
            ),
        );
    }

    public static function invalid_route_callback_result(): self
    {
        return new self("route callback must be of type " . http\response\response::class);
    }
}
