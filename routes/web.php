<?php

use App\controller\HomeController;

return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/a/{id:\d+}', [HomeController::class, 'show']],
    ['GET', '/hello/{name:.+}', function (string $name) {
        return new \allbertss\psittacorum\Http\Response("Hello $name");
    }],
];