<?php

namespace allbertss\psittacorum\console;

use allbertss\psittacorum\console\exception\ConsoleException;
use Psr\Container\ContainerInterface;

class Application
{
    public function __construct(
        private ContainerInterface $container
    )
    {
    }

    public function run(): int
    {
        $arguments = $_SERVER['argv'];

        $commandName = $arguments[1] ?? null;

        if (!$commandName) {
            throw new ConsoleException('Command name must be provided.');
        }

        $command = $this->container->get($commandName);

        $commandArguments = array_slice($arguments, 2);

        $options = $this->parseOptions($commandArguments);

        $status = $command->execute($options);

        return $status;
    }

    private function parseOptions(array $arguments): array
    {
        return array_reduce($arguments, function ($accumulator, $argument) {
            if (str_starts_with($argument, '--')) {
                $option = explode('-', substr($argument, 2));

                $accumulator[$option[0]] = $option[1] ?? true;
            }

            return $accumulator;
        }, []);
    }
}