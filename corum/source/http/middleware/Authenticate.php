<?php

namespace allbertss\psittacorum\http\middleware;

use allbertss\psittacorum\http\Request;
use allbertss\psittacorum\http\Response;

class Authenticate implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        if (false) {
            return new Response("Authentication failed", 401);
        }

        return $requestHandler->handle($request);
    }
}