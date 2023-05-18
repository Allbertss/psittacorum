<?php

namespace allbertss\psittacorum\http\middleware;

use allbertss\psittacorum\http\Request;
use allbertss\psittacorum\http\Response;
use allbertss\psittacorum\session\SessionInterface;

class StartSession implements MiddlewareInterface
{
    public function __construct(
        private SessionInterface $session
    )
    {
    }

    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        // TODO: consider when not to start session (API routes, ...)
        $this->session->start();

        $request->setSession($this->session);

        return $requestHandler->handle($request);
    }
}