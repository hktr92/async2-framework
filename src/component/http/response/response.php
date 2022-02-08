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

use function fastcgi_finish_request;
use function function_exists;
use function header;
use function http_response_code;

/**
 * @package async2
 *
 * generic http response class.
 *
 * it's naming reflects the builder pattern, but it's not mandatory.
 *
 * pro tip: try and use named parameters when constructing this class.
 */
class response
{
    public function __construct(
        protected status_code $status = status_code::ok,
        protected string $body = '',
        protected content_type $content_type = content_type::html,
    ) {
    }

    /**
     * sets the response body.
     */
    public function with_body(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * sets the response status code.
     */
    public function with_status_code(status_code $status_code): self
    {
        $this->status = $status_code;

        return $this;
    }

    /**
     * sets the response content type.
     * TODO: implement headers bucket so we don't have to manually define content-type.
     */
    public function with_content_type(content_type $content_type): self
    {
        $this->content_type = $content_type;

        return $this;
    }

    /**
     * sends the response back to the client.
     */
    public function send(): void
    {
        http_response_code($this->status->value);

        // TODO -- implement headers, just like in request::$headers
        header("Content-Type: {$this->content_type->value}");

        echo $this->body;

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } else {
            exit;
        }
    }
}
