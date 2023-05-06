<?php

namespace allbertss\psittacorum\routing;

use allbertss\psittacorum\Http\Request;
use allbertss\psittacorum\routing\RouterInterface;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    public function dispatch(Request $request): array
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $routeCollector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInformation(),
        );

        [$statusCode, [$controller, $method], $variables] = $routeInfo;

        return [[new $controller, $method], $variables];
    }
}