<?php

namespace allbertss\psittacorum\console\command\migrate;

use allbertss\psittacorum\console\command\CommandInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;

class RollbackDatabase implements CommandInterface
{
    private string $name = 'database:migrations:rollback';

    public function __construct(
        private Connection $connection,
        private string     $migrationsPath
    )
    {
    }

    public function execute(array $parameters = []): int
    {
        try {
            $this->connection->beginTransaction();

            $migrations = $this->getExecutedMigrations();

            if (empty($migrations)) {
                echo "No executed migrations to rollback" . PHP_EOL;

                return 0;
            }

            $migration = (end($migrations))['migration'];

            $migrationObject = require $this->migrationsPath . '/' . $migration;

            $migrationObject->down(new Schema());

            $this->connection->commit();

            echo "Rolled back migration." . PHP_EOL;
        } catch (\Throwable $throwable) {
            $this->connection->rollBack();

            throw $throwable;
        }

        return 0;
    }

    private function getExecutedMigrations(): array
    {
        return $this->connection->fetchAllAssociative("SELECT migration FROM migrations ORDER BY id DESC");
    }
}