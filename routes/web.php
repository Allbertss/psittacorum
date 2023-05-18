<?php

use App\controller\HomeController;

return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/hello/{name:.+}', function (string $name) {
        return new \allbertss\psittacorum\Http\Response("Hello $name");
    }],
    ['GET', '/home/{id:\d+}', [HomeController::class, 'show']],
    ['GET', '/homes', [HomeController::class, 'showAll']],
    ['GET', '/home', [HomeController::class, 'create']],
    ['POST', '/home', [HomeController::class, 'store']],
];