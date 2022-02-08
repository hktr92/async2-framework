<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\router;

use async2\component\http\request;
use async2\framework\exception;

/**
 * @package async2
 *
 * exception thrown when no routes were found.
 */
final class not_found_http_exception extends exception
{
    public function __construct(
        public readonly request $request,
    ) {
        parent::__construct(message: "RouteNotFound");
    }
}
