<?php

namespace allbertss\psittacorum\Http;

use allbertss\psittacorum\routing\Router;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{
    public function __construct(
        private Router $router
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            [$routeHandler, $variables] = $this->router->dispatch($request);

            $response = call_user_func_array($routeHandler, $variables);
        } catch (\Exception $exception) {
            $response = new Response($exception->getMessage(), 400);
        }

        return $response;
    }
}