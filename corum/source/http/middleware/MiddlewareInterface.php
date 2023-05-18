<?php

namespace allbertss\psittacorum\http\middleware;

use allbertss\psittacorum\http\Request;
use allbertss\psittacorum\http\Response;

interface MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response;
}