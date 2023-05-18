<?php

namespace allbertss\psittacorum\http\middleware;

use allbertss\psittacorum\http\Request;
use allbertss\psittacorum\http\Response;

class RequestHandler implements RequestHandlerInterface
{
    private array $middleware = [
        Authenticate::class,
    ];

    public function handle(Request $request): Response
    {
        if (empty($this->middleware)) {
            return new Response("Server error.", 500);
        }

        $middlewareClass = array_shift($this->middleware);

        return (new $middlewareClass)->process($request, $this);
    }
}