<?php

declare(strict_types = 1);

use allbertss\psittacorum\Http\Request;
use allbertss\psittacorum\Http\Response;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$response = new Response(
    '<b>Hello</b> world',
    200,
    []
);

$response->send();