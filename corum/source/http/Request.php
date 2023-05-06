<?php

namespace allbertss\psittacorum\http;

readonly class Request
{
    public function __construct(
        public readonly array $getParameters,
        public readonly array $postParameters,
        public readonly array $cookies,
        public readonly array $files,
        public readonly array $server,
    )
    {

    }

    public static function createFromGlobals(): static
    {
        return new static(
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES,
            $_SERVER
        );
    }

    public function getPathInformation(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }
}