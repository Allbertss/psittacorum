<?php

declare(strict_types = 1);

use allbertss\psittacorum\Http\Request;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

dd($request);

echo 'Hello world';