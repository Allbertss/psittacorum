<?php

namespace allbertss\psittacorum\http;

class Response
{
    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    public function __construct(
        private ?string $content = '',
        private int $statusCode = 200,
        private array $headers = []
    )
    {
        http_response_code($this->statusCode);
    }

    public function send(): void
    {
        echo $this->content;
    }

    public function setContent(?string $content): Response
    {
        $this->content = $content;

        return $this;
    }
}