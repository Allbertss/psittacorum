<?php

namespace allbertss\psittacorum\routing;

use allbertss\psittacorum\Http\exception\HttpException;
use allbertss\psittacorum\Http\exception\HttpRequestMethodException;
use allbertss\psittacorum\Http\Request;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
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

    /**
     * @param Request $request
     * @return array
     * @throws HttpException
     * @throws HttpRequestMethodException
     */
    private function extractRouteInformation(Request $request): array
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $routeCollector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
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

                throw new HttpRequestMethodException("The allowed methods are $allowMethods");
            default:
                throw new HttpException('Not found');
        }
    }
}