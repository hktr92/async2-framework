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

use async2\component\http\request;
use async2\framework\kernel;

/**
 * sample application bootstrap for async2 framework.
 */


// auto-load the dependencies.
require_once dirname(__DIR__) . "/vendor/autoload.php";

// this is for dev mode.
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// initialize the request
$request = new request();

// initialize the kernel
$kernel = new kernel(dirname(__FILE__) . '/config');

// handle the request and you're done.
$kernel->handle($request);