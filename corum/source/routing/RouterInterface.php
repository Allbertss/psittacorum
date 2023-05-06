<?php

namespace allbertss\psittacorum\routing;

use allbertss\psittacorum\http\Request;
use Psr\Container\ContainerInterface;

interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container);

    public function setRoutes(array $routes): void;
}