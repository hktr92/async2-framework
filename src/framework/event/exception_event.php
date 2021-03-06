<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\framework\event;

use async2\component\event\event;
use async2\component\http\context;

/**
 * @package async2
 *
 * event emitted by framework when an exception occurred during the current request.
 */
class exception_event extends event
{
    public function __construct(
        public readonly context $context,
    ) {
    }
}
