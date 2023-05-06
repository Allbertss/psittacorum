<?php

$container = new \League\Container\Container();

$container->add(
    \allbertss\psittacorum\routing\RouterInterface::class,
    \allbertss\psittacorum\routing\Router::class
);

$container->add(
    \allbertss\psittacorum\http\Kernel::class
)->addArgument(\allbertss\psittacorum\routing\RouterInterface::class);

return $container;