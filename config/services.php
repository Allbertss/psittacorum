<?php

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$container = new \League\Container\Container();

$container->delegate(
    new \League\Container\ReflectionContainer(true)
);

$routes = include BASE_PATH . '/routes/web.php';
$appEnv = $_ENV['APP_ENV'];

$container->add(
    'APP_ENV',
    new \League\Container\Argument\Literal\StringArgument($appEnv)
);

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
)
    ->addArgument(\allbertss\psittacorum\routing\RouterInterface::class)
    ->addArgument($container);

return $container;