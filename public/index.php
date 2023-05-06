<?php

declare(strict_types = 1);

use allbertss\psittacorum\http\Request;
use allbertss\psittacorum\http\Kernel;
use allbertss\psittacorum\routing\Router;

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$kernel = new Kernel(new Router());
$response = $kernel->handle($request);

$response->send();