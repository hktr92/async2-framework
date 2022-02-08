<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace async2\component\http;

use async2\component\data_type\bucket;
use async2\framework\exception;
use async2\util\xstring;

use function parse_url;

use const PHP_URL_PATH;

/**
 * @package async2
 *
 * a simple class that holds info related to incoming requests' url data.
 */
final class url
{
    public function __construct(
        public readonly string $method,
        public readonly xstring $uri,
        public readonly bucket $params,
    ) {
    }

    /**
     * this is not actually a parse... it simply builds the final url object that contains a sane request_uri.
     */
    public static function parse(request $request): self
    {
        /** @psalm-var array<string, string> $_GET */
        $request_uri = parse_url(
            url: $request->server->get('request_uri')->to_str(),
            component: PHP_URL_PATH,
        );

        if (false === $request_uri) {
            throw new exception("unable to parse request_uri");
        }

        return new url(
            method: $request->server->get('request_method')->lower()->to_str(),
            uri: new xstring($request_uri),
            params: bucket::from($_GET),
        );
    }
}
