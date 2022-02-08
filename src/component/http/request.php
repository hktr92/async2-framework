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

namespace async2\component\http;

use async2\component\data_type\bucket;
use async2\component\file\file;
use async2\component\json\json;
use async2\util\stream\php_stream;
use Throwable;

use function is_array;
use function str_replace;
use function str_starts_with;
use function strtolower;
use function substr;

/**
 * @package async2
 *
 * this class holds every incoming request that you'd need for your handler.
 *
 * some disclaimers:
 * - $_SERVER is split into $headers and $server.
 * - $server can also be used for env vars.
 * - $input contains both $_POST and any possibly JSON body that comes in through php://input.
 * - $url contains current request's url info
 * - $files is currently an array, will be made into a full-blown class.
 * - $_GET parameters are stored in $url->params.
 * - url class does not support (yet) array params (e.g. $_GET['foo'][0]).
 */
final class request
{
    public readonly bucket $headers;
    public readonly bucket $server;
    public readonly bucket $input;

    public readonly array $files;

    public readonly url $url;

    public function __construct()
    {
        $this->input = $this->init_input();
        $this->files = $_FILES;
        $this->headers = $this->init_headers();
        $this->server = $this->init_server();

        $this->url = url::parse($this);
    }

    /**
     * initializes the $input parameter.
     *
     * - it collects everything from $_POST.
     * - tries to decode json body and merge with $input
     * - return the bucket.
     */
    private function init_input(): bucket
    {
        /**
         * @psalm-var array<string, mixed> $_POST
         */
        $input = $_POST;

        try {
            $body = file::read_contents(php_stream::input);
            $body = json::decode($body);

            if (is_array($body)) {
                /**
                 * @psalm-var array<string, mixed> $body
                 * @psalm-var array<string, mixed> $input
                 */
                $input = [...$input, ...$body];
            }
        } catch (Throwable) {
            // do nothing
        }

        return bucket::from($input);
    }

    /**
     * initializes headers bucket.
     *
     * for some reasons, php puts all incoming http headers with the HTTP_ prefix in $_SERVER
     * i'm splitting them back
     */
    private function init_headers(): bucket
    {
        /** @psalm-var array<string, string|int> $_SERVER */
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (false === str_starts_with($key, 'HTTP_')) {
                continue;
            }

            $name = substr($key, 5);
            $name = str_replace('_', '-', $name);
            $name = strtolower($name);
            $headers[$name] = $value;
        }

        return bucket::from($headers);
    }

    /**
     * for some reasons, php puts all env vars inside $_SERVER.
     * i'm taking them back, filtering out http headers.
     */
    private function init_server(): bucket
    {
        /** @psalm-var array<string, string|int> $_SERVER */
        $server = [];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                continue;
            }

            $server[strtolower($key)] = $value;
        }

        return bucket::from($server);
    }

    /**
     * this is interesting and worth working more with it...
     *
     * logic:
     * - tries to determine content-type requested by the browser.
     * - falls back to url-based content-type (e.g. /foos.json => json content type_
     * - falls back to content_type::html
     *
     * this should be improved even more.
     */
    public function content_type(): content_type
    {
        // 1. use the "Accept" content type header
        /** @psalm-var null|content_type $content_type */
        $content_type = content_type::tryFrom($this->headers->get('accept')->to_str());

        if (null === $content_type) {
            // 2. fallback: use route override content-type
            $content_type = content_type::from_request_uri($this->url->uri);
        }

        return $content_type;
    }
}
