<?php

namespace allbertss\psittacorum\console\command\migrate;

use allbertss\psittacorum\console\command\CommandInterface;

class MigrateDatabase implements CommandInterface
{
    private string $name = 'database:migrations:migrate';

    public function execute(array $parameters = []): int
    {
        return 0;
    }
}