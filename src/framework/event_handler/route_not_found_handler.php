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
use async2\component\http\response\status_code;
use async2\component\router\not_found_http_exception;
use async2\framework\event\exception_event;
use async2\framework\kernel_event;

use function sprintf;

#[event\on(name: kernel_event::exception)]
final class route_not_found_handler
{
    public function __invoke(exception_event $event): exception_event
    {
        if ($event->context->throwable instanceof not_found_http_exception) {
            $message = "route %s '%s' was not found on this server.";

            $event
                ->context
                ->response
                ->with_body(
                    sprintf(
                        $message,
                        $event->context->request->url->method,
                        $event->context->request->url->uri->to_str(),
                    ),
                )
                ->with_status_code(status_code::not_found);
        }

        return $event;
    }
}