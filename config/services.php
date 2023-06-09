<?php

// TODO: extract into corum
// TODO: refactor into multiple files

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
    'base-commands-namespace',
    new \League\Container\Argument\Literal\StringArgument('allbertss\\psittacorum\\console\\command\\migrate\\')
);

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
    \allbertss\psittacorum\http\middleware\RequestHandlerInterface::class,
    \allbertss\psittacorum\http\middleware\RequestHandler::class
)->addArgument($container);

$container->add(\allbertss\psittacorum\http\Kernel::class)->addArguments([
    \allbertss\psittacorum\routing\RouterInterface::class,
    $container,
    \allbertss\psittacorum\http\middleware\RequestHandlerInterface::class
]);

$container->addShared(
    \allbertss\psittacorum\session\SessionInterface::class,
    \allbertss\psittacorum\session\Session::class
);

$container->add('template-renderer-factory', \allbertss\psittacorum\template\TwigFactory::class)
    ->addArguments([
        \allbertss\psittacorum\session\SessionInterface::class,
        new \League\Container\Argument\Literal\StringArgument($templatePath)
    ]);

$container->addShared('twig', function () use ($container) {
    return $container->get('template-renderer-factory')->create();
});

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

$container->add(\allbertss\psittacorum\console\Kernel::class)
    ->addArguments([
        $container,
        \allbertss\psittacorum\console\Application::class
    ]);

$container->add(\allbertss\psittacorum\console\Application::class)
    ->addArgument($container);

$container->add('database:migrations:migrate', \allbertss\psittacorum\console\command\migrate\MigrateDatabase::class)
    ->addArguments([
        \Doctrine\DBAL\Connection::class,
        new \League\Container\Argument\Literal\StringArgument(BASE_PATH . '/migrations')
    ]);

$container->add('database:migrations:rollback', \allbertss\psittacorum\console\command\migrate\RollbackDatabase::class)
    ->addArguments([
        \Doctrine\DBAL\Connection::class,
        new \League\Container\Argument\Literal\StringArgument(BASE_PATH . '/migrations')
    ]);

$container->add(\allbertss\psittacorum\http\middleware\RouterDispatch::class)
    ->addArguments([
        \allbertss\psittacorum\routing\RouterInterface::class,
        $container
    ]);

return $container;