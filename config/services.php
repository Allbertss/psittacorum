<?php

$container = new \League\Container\Container();

$routes = include BASE_PATH . '/routes/web.php';

$container->add(
    \allbertss\psittacorum\routing\RouterInterface::class,
    \allbertss\psittacorum\routing\Router::class
);

$container->extend(
    \allbertss\psittacorum\routing\RouterInterface::class
)->addMethodCall(
    'setRoutes',
    [new \League\Container\Argument\Literal\ArrayArgument($routes)]
);

$container->add(
    \allbertss\psittacorum\http\Kernel::class
)->addArgument(\allbertss\psittacorum\routing\RouterInterface::class);

return $container;