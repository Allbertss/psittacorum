<?php

namespace allbertss\psittacorum\routing;

use allbertss\psittacorum\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}