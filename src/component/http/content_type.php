<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace async2\component\http;

use async2\util\xstring;

/**
 * @package async2
 *
 * enum that contains various common content-type type.
 *
 * more to come.
 */
enum content_type: string
{
    case html = 'text/html';
    case json = 'application/json';

    public static function from_request_uri(xstring $uri): self
    {
        if ($uri->ends_with('json')) {
            return self::json;
        }

        return self::html;
    }
}
