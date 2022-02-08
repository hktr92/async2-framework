<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\framework;

/**
 * @package async2
 *
 * enum that contains all events emitted by the kernel.
 */
enum kernel_event: string
{
    case exception = 'exception';
}
