<?php

namespace allbertss\psittacorum\Http;

use allbertss\psittacorum\Http\exception\HttpException;
use allbertss\psittacorum\Http\exception\HttpRequestMethodException;
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
        } catch (HttpRequestMethodException $exception) {
            $response = new Response($exception->getMessage(), 405);
        } catch (HttpException $exception) {
            $response = new Response($exception->getMessage(), 404);
        } catch (\Exception $exception) {
            $response = new Response($exception->getMessage(), 500);
        }

        return $response;
    }
}