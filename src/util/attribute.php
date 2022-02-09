<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\util;

use async2\component\event\on;
use ReflectionClass as reflection_class;
use ReflectionMethod as reflection_method;

use function count;

/**
 * @package async2
 *
 * simple class that collects attributes from class (and it's methods)
 *
 * @psalm-type _attribute_data array{attribute: \ReflectionAttribute<object>, callback: callable}
 */
final class attribute
{
    /**
     * @psalm-var array<class-string, list<_attribute_data>>
     */
    private static $memoized_map = [];

    /**
     * @psalm-return list<_attribute_data>
     */
    public static function get(object $object, ?string $target_attribute = null): array
    {
        if (isset(self::$memoized_map[$object::class])) {
            return self::$memoized_map[$object::class];
        }

        $attributes = [];
        $reflection = new reflection_class($object);

        // 1. get class attributes
        if ($reflection->hasMethod('__invoke')) {
            foreach ($reflection->getAttributes($target_attribute) as $attribute) {
                $attributes[] = [
                    'attribute' => $attribute,
                    'callback' => $reflection->newInstance()->__invoke(...),
                ];
            }
        }

        // 2. get public methods attributes
        foreach ($reflection->getMethods(reflection_method::IS_PUBLIC) as $method) {
            $method_attributes = $method->getAttributes(on::class);

            if (count($method_attributes) === 0) {
                continue;
            }

            foreach ($method_attributes as $attribute) {
                $attributes[] = [
                    'attribute' => $attribute,
                    'callback' => $method->getClosure($object),
                ];
            }
        }

        self::$memoized_map[$object::class] = $attributes;

        return $attributes;
    }
}
