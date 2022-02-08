<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\json;

use function json_decode;
use function json_encode;

/**
 * @package async2
 *
 * this json component wraps up the classic json_* functions.
 */
final class json
{
    public static function decode(string $text, decode $mode = decode::array): array|object
    {
        /** @psalm-var array|object $data */
        $data = json_decode(
            json: $text,
            associative: $mode->json_assoc(),
        );

        return $data;
    }

    public static function encode(array $data): string
    {
        return json_encode($data, flags: JSON_THROW_ON_ERROR);
    }
}
