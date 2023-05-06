<?php

use App\controller\HomeController;

return [
    ['GET', '/', [HomeController::class, 'index']],
];