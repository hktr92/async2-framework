<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\event;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;

use function count;
use function is_string;

/**
 * @package async2
 *
 * a simple event_bus class.
 *
 * currently, the priority has no effect, since it's controllable when registering handlers.
 *
 * this event_bus is targeted to be used in small areas, e.g. if you have a service that performs stuff, you'd better
 * allocate one for your project instead of relying on a global event_bus.
 *
 * additionally, the event's name is defined here to be a string, but a string-based enum is recommended when implementing
 * it in your service.
 *
 * @psalm-type _event_handlers list<array{priority:int, listener:callable(event):event}>
 * @psalm-type _events_map array<string, _event_handlers>
 */
final class event_bus
{
    /**
     * @psalm-param _events_map $events
     */
    public function __construct(
        private array $events = [],
    ) {
    }

    /**
     * registers a handler for a given event name.
     */
    public function on(
        string $name,
        callable $listener,
        int $priority = 10,
    ): void {
        /** @psalm-var callable(event):event $listener */
        $this->events[$name][] = [
            'priority' => $priority,
            'listener' => $listener,
        ];
    }

    /**
     * triggers the execution of all listeners on a given name.
     */
    public function emit(string $name, event $event): event
    {
        $handlers = $this->events[$name] ?? [];

        foreach ($handlers as $handler) {
            if ($event->is_propagation_stopped()) {
                break;
            }

            $returned_event = $handler['listener']($event);
            if ($returned_event instanceof event) {
                $event = $returned_event;
            }
        }

        return $event;
    }

    /**
     * auto-registers the handlers, if any
     */
    public function discover(object $object): void
    {
        // TODO -- use local event bus
//        if (false === property_exists($object, 'event_bus')) {
//            return;
//        }

        $reflection = new ReflectionClass($object);

        // 1. get class attributes
        if ($reflection->hasMethod('__invoke')) {
            $class_attributes = $reflection->getAttributes(on::class);
            foreach ($class_attributes as $attribute) {
                $this->register_from_attribute(
                    attribute: $attribute,
                    callback: $reflection->newInstance()->__invoke(...),
                );
            }
        }

        // 2. get public methods attributes
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $method_attributes = $method->getAttributes(on::class);

            if (count($method_attributes) === 0) {
                continue;
            }

            foreach ($method_attributes as $attribute) {
                $this->register_from_attribute(
                    attribute: $attribute,
                    callback: $method->getClosure($object)
                );
            }
        }
    }

    private function register_from_attribute(ReflectionAttribute $attribute, callable $callback): void
    {
        /** @psalm-var on $on_config */
        $on_config = $attribute->newInstance();

        $name = !is_string($on_config->name) ? $on_config->name->value : $on_config->name;

        $this->on(
            name: $name,
            listener: $callback,
            priority: $on_config->priority,
        );
    }
}
