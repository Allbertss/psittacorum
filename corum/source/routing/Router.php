<?php

namespace allbertss\psittacorum\routing;

use allbertss\psittacorum\http\exception\HttpException;
use allbertss\psittacorum\http\exception\HttpRequestMethodException;
use allbertss\psittacorum\http\Request;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    private array $routes;

    /**
     * @param Request $request
     * @return array
     * @throws HttpException
     * @throws HttpRequestMethodException
     */
    public function dispatch(Request $request): array
    {
        [$handler, $variables] = $this->extractRouteInformation($request);

        if (is_array($handler)) {
            [$controller, $method] = $handler;

            $handler = [new $controller, $method];
        }

        return [$handler, $variables];
    }

    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * @param Request $request
     * @return array
     * @throws HttpException
     * @throws HttpRequestMethodException
     */
    private function extractRouteInformation(Request $request): array
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $routeCollector) {
            foreach ($this->routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        $routeInformation = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInformation(),
        );

        switch ($routeInformation[0]) {
            case Dispatcher::FOUND:
                return [$routeInformation[1], $routeInformation[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowMethods = implode(', ', $routeInformation[1]);

                throw new HttpRequestMethodException("The allowed methods are $allowMethods", 405);
            default:
                throw new HttpException('Not found', 404);
        }
    }
}