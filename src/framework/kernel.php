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

namespace async2\framework;

use async2\component\event\event_bus;
use async2\component\file\file;
use async2\component\http\request;
use async2\component\http\response\response;
use async2\component\http\response\status_code;
use async2\component\router\not_found_http_exception;
use async2\component\router\route_match_event;
use async2\component\router\router;
use async2\component\router\router_event;
use async2\framework\event\exception_event;
use Throwable;

/**
 * @package async2
 *
 * this is the framework's kernel, which processes the incoming request, bootstraps the router, handles the exception
 * and sends the response back to the client.
 */
final class kernel
{
    private event_bus $event_bus;
    private router $router;

    public function __construct(
        private string $config_dir = '',
    ) {
        $this->event_bus = new event_bus();
        $this->router = new router();

        $this->init_default_error_handler();
    }

    /**
     * registers an event handler for kernel_event
     */
    public function on(
        kernel_event $name,
        callable $listener,
        int $priority = 10,
    ): void {
        $this->event_bus->on(
            name: $name->value,
            listener: $listener,
            priority: $priority,
        );
    }

    /**
     * handles the incoming request and emits a kernel_event::exception.
     */
    public function handle(request $request): void
    {
        try {
            $this->load_routes("$this->config_dir/routes.php");

            $this->router->on(
                router_event::matched,
                fn(route_match_event $event) => $event
                    ->response
                    ->with_content_type(
                        $event->request->content_type(),
                    ),
            );

            $this->router->handle($request);
        } catch (Throwable $t) {
            /** @psalm-var exception_event $event */
            $event = $this->event_bus->emit(
                name: kernel_event::exception->value,
                event: new exception_event(
                    throwable: $t,
                    request: $request,
                    response: new response(
                        status: status_code::internal_server_error,
                        body: "Whoops! Something went wrong.",
                    ),
                ),
            );

            $event->response->send();
        }
    }

    /**
     * loads routes definition.
     */
    private function load_routes(string $routes_config): void
    {
        if (false === file::exists($routes_config)) {
            return;
        }

        /** @psalm-suppress UnresolvableInclude */
        // TODO(psalm-fix)
        (require_once $routes_config)($this->router);
    }

    /**
     * a default error handler that checks whether the caught exception is 404 or else.
     */
    private function init_default_error_handler(): void
    {
        $this->on(
            name: kernel_event::exception,
            listener: function (exception_event $event) {
                if ($event->throwable instanceof not_found_http_exception) {
                    $message = "route %s '%s' was not found on this server.";

                    $event
                        ->response
                        ->with_body($message)
                        ->with_status_code(status_code::not_found);
                }

                return $event;
            },
            priority: -100,
        );
    }
}
