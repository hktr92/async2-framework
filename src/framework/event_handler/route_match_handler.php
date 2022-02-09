<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\framework\event_handler;

use async2\component\event;
use async2\component\router\route_match_event;
use async2\component\router\router_event;

#[event\on(router_event::matched)]
final class route_match_handler
{
    public function __invoke(route_match_event $event): route_match_event
    {
        $event
            ->context
            ->response
            ->with_content_type(
                $event
                    ->context
                    ->request
                    ->content_type(),
            );

        return $event;
    }
}
