<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\http;

use async2\component\http\response\response;
use Throwable;

/**
 * @package async2
 *
 * class that provides a simple context for any route.
 */
final class context
{
    public function __construct(
        public readonly request $request,
        public response $response = new response(),
        public ?Throwable $throwable = null,
    ) {
    }
}
