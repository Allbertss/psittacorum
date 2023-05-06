<?php

namespace allbertss\psittacorum\http;

use allbertss\psittacorum\http\exception\HttpException;
use allbertss\psittacorum\routing\RouterInterface;

class Kernel
{
    public function __construct(
        private RouterInterface $router
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