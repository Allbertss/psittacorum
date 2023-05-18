<?php

namespace allbertss\psittacorum\http;

// TODO: use psr-15 Request interface
use allbertss\psittacorum\session\SessionInterface;

readonly class Request
{
    private SessionInterface $session;

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

    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    public function setSession(SessionInterface $session): void
    {
        $this->session = $session;
    }

    public function input(mixed $key): mixed
    {
        return $this->postParameters[$key];
    }
}