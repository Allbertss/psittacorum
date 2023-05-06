<?php

namespace allbertss\psittacorum\routing;

use allbertss\psittacorum\http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}