<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\router;

use async2\component\event\event;
use async2\component\http\request;
use async2\component\http\response\response;

/**
 * @package async2
 *
 * event emitted when a route was matched by the router
 */
final class route_match_event extends event
{
    public function __construct(
        public readonly request $request,
        public readonly response $response,
    ) {
    }
}
