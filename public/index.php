<?php

declare(strict_types = 1);

use allbertss\psittacorum\Http\Request;
use allbertss\psittacorum\Http\Kernel;

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$kernel = new Kernel();
$response = $kernel->handle($request);

$response->send();