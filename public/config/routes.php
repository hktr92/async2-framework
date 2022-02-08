<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use async2\component\http\context;
use async2\component\http\response\json_response;
use async2\component\http\response\response;
use async2\component\router\router;

/**
 * sample routes registration.
 */
return static function (router $router): void {
    $router->get('/', function (context $context) {
        $name = $context->request->url->params->get('name', 'world');

        return new response(
            body: "hello, $name!"
        );
    });

    $router->get('/index.json', function (context $context) {
        $name = $context->request->url->params->get('name', 'world');

        return new json_response(
            body: ['message' => "hello, $name!"]
        );
    });
};