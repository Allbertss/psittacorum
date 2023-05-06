<?php

use App\controller\HomeController;

return [
    ['GET', '/', [HomeController::class, 'index']],
    ['GET', '/a/{id:\d+}', [HomeController::class, 'show']],
];