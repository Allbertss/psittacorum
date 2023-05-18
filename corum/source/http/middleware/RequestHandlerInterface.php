<?php

namespace allbertss\psittacorum\http\middleware;

use allbertss\psittacorum\http\Request;
use allbertss\psittacorum\http\Response;

// TODO: use psr-15 RequestHandlerInterface
interface RequestHandlerInterface
{
    public function handle(Request $request): Response;
}