<?php

// TODO: add readonly

declare(strict_types = 1);

use allbertss\psittacorum\http\Request;
use allbertss\psittacorum\http\Kernel;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$container = require BASE_PATH . '/config/services.php';

$request = Request::createFromGlobals();

$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);