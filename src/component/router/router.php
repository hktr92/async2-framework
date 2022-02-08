<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\router;

use async2\component\event\event_bus;
use async2\component\http;

/**
 * @package async2
 *
 * a simple uri-based router. it calls the callback when a request_method + request_uri is matched.
 *
 * current downside:
 * - only one handler / path / method is allowed.
 *
 * @psalm-type _http_methods "get"|"post"|"put"|"delete"
 * @psalm-type _route_def array<string, callable(http\context):http\response\response>
 * @psalm-type _routes_definition array<_http_methods, _route_def>
 */
final class router
{
    /**
     * @psalm-param _routes_definition $routes
     */
    public function __construct(
        private event_bus $event_bus = new event_bus(),
        private array $routes = [],
    ) {
    }

    /**
     * register an event for router.
     */
    public function on(
        router_event $event,
        callable $listener,
        int $priority = 10,
    ): void {
        $this->event_bus->on(
            name: $event->name,
            listener: $listener,
            priority: $priority,
        );
    }

    /**
     * generic route registration.
     */
    public function use(http\method $method, string $path, callable $callback): self
    {
        /** @psalm-var callable(http\context):http\response\response $callback */
        if (isset($this->routes[$method->value][$path])) {
            throw router_exception::route_already_defined($method, $path);
        }

        $this->routes[$method->value][$path] = $callback;

        return $this;
    }

    /**
     * defines a getter on a given path
     */
    public function get(string $path, callable $callback): self
    {
        return $this->use(http\method::get, $path, $callback);
    }

    /**
     * performs route matching, then emits an router_event::matched event with the result.
     */
    public function handle(http\context $context): http\response\response
    {
        $request = $context->request;

        foreach ($this->routes as $method => $paths) {
            if ($method !== $request->url->method) {
                continue;
            }

            foreach ($paths as $path => $callback) {
                if ($path !== $request->url->uri->to_str()) {
                    continue;
                }

                $response = $callback($context);

                if (false === ($response instanceof http\response\response)) {
                    throw router_exception::invalid_route_callback_result();
                }

                $context->response = $response;

                /** @psalm-var route_match_event $event */
                $event = $this->event_bus->emit(
                    name: router_event::matched->value,
                    event: new route_match_event(
                        context: $context,
                    ),
                );

                return $event->context->response;
            }
        }

        throw new not_found_http_exception($request);
    }
}
