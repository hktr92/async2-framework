<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\http\response;

use async2\component\http\content_type;
use async2\component\json\json;

use function is_array;

/**
 * @package async2
 *
 * helps you build a json response from array.
 */
class json_response extends response
{
    public function __construct(
        status_code $status = status_code::ok,
        string|array $body = '',
    ) {
        if (is_array($body)) {
            $body = json::encode($body);
        }

        parent::__construct(
            status: $status,
            body: $body,
            content_type: content_type::json,
        );
    }
}
