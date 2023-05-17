<?php

namespace allbertss\psittacorum\console;

use allbertss\psittacorum\console\command\CommandInterface;
use Psr\Container\ContainerInterface;

final class Kernel
{
    // TODO: wrap ContainerInterface to my own interface to make sure it always has ->get method.
    public function __construct(
        private ContainerInterface $container
    )
    {
    }

    /*
     * Statuses
     * 0 - The application completed successfully.
     * 1 - The application encountered an error or invalid input.
     * 2 - The application was unable to find the specified file.
     * 3 - The application encountered a runtime error.
     * 4 - The application ran out of memory.
     * 5 - The user cancelled the application.
     * 6 - The application attempted to access a resource it was not authorized to use.
     * 7 - The application encountered an internal error or crash.
     * 8 - The application encountered a network error.
     * 9 - The application was terminated by a signal.
     */
    public function handle(): int
    {
        $this->registerCommands();

        dd($this->container);

        return 0;
    }

    private function registerCommands(): void
    {
        // TODO: make it work with all folders inside /command
        $commandFiles = new \DirectoryIterator(__DIR__ . '/command/migrate');

        // TODO: take namespace dynamically
        $namespace = $this->container->get('base-commands-namespace');

        foreach ($commandFiles as $commandFile) {
            if (!$commandFile->isFile()) {
                continue;
            }

            $command = $namespace.pathinfo($commandFile, PATHINFO_FILENAME);

            if (is_subclass_of($command, CommandInterface::class)) {
                $commandName = (new \ReflectionClass($command))->getProperty('name')->getDefaultValue();

                $this->container->add($commandName, $command);
            }
        }

        // TODO: register all user-defined commands
    }
}