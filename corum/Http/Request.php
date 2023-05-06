<?php

namespace allbertss\psittacorum\Http;

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
}