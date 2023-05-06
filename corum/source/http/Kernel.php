<?php

namespace allbertss\psittacorum\Http;

use allbertss\psittacorum\Http\exception\HttpException;
use allbertss\psittacorum\routing\Router;

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
        } catch (HttpException $exception) {
            $response = new Response($exception->getMessage(), $exception->getStatusCode());
        } catch (\Exception $exception) {
            $response = new Response($exception->getMessage(), 500);
        }

        return $response;
    }
}