<?php

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(BASE_PATH . '/.env');

$container = new \League\Container\Container();

$container->delegate(
    new \League\Container\ReflectionContainer(true)
);

$routes = include BASE_PATH . '/routes/web.php';
$templatePath = BASE_PATH . '/template';
$appEnv = $_ENV['APP_ENV'];

$databaseUrl = 'sqlite:///' . BASE_PATH . '/var/db.sqlite';

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

$container->addShared('file-system-loader', \Twig\Loader\FilesystemLoader::class)
    ->addArgument(new \League\Container\Argument\Literal\StringArgument($templatePath));

$container->addShared('twig', \Twig\Environment::class)
    ->addArgument('file-system-loader');

$container->add(\allbertss\psittacorum\controller\AbstractController::class);

$container->inflector(\allbertss\psittacorum\controller\AbstractController::class)
    ->invokeMethod('setContainer', [$container]);

$container->add(\allbertss\psittacorum\databaseAbstractionLayer\ConnectionFactory::class)
    ->addArguments([
        new \League\Container\Argument\Literal\StringArgument($databaseUrl)
    ]);

$container->addShared(\Doctrine\DBAL\Connection::class, function () use ($container): \Doctrine\DBAL\Connection {
    return $container->get(\allbertss\psittacorum\databaseAbstractionLayer\ConnectionFactory::class)->createConnection();
});

return $container;