<?php

namespace allbertss\psittacorum\console\command\migrate;

use allbertss\psittacorum\console\command\CommandInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

class MigrateDatabase implements CommandInterface
{
    private string $name = 'database:migrations:migrate';

    public function __construct(
        private Connection $connection,
        private string $migrationsPath
    )
    {
    }

    public function execute(array $parameters = []): int
    {
        try {
            $this->createMigrationsTable();

            $this->connection->beginTransaction();

            $migrationsToApply = array_diff($this->getMigrationsFiles(), $this->getAppliedMigrations());

            $schema = new Schema();

            foreach ($migrationsToApply as $migration) {
                $migrationObject = require $this->migrationsPath . '/' . $migration;

                $migrationObject->up($schema);

                $this->insertMigration($migration);
            }

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

            foreach ($sqlArray as $sql) {
                $this->connection->executeQuery($sql);
            }

            $this->connection->commit();
        } catch (\Throwable $throwable) {
            $this->connection->rollBack();

            throw $throwable;
        }

        return 0;
    }

    private function createMigrationsTable(): void
    {
        $schemaManager = $this->connection->createSchemaManager();

        if ($schemaManager->tablesExist('migrations')) {
            return;
        }

        $schema = new Schema();

        $table = $schema->createTable('migrations');

        $table->addColumn('id', Types::INTEGER, [
            'unsigned' => true,
            'autoincrement' => true
        ]);
        $table->addColumn('migration', Types::STRING);
        $table->addColumn('created_at', TYPES::DATETIME_IMMUTABLE, [
            'default' => 'CURRENT_TIMESTAMP'
        ]);

        $table->setPrimaryKey(['id']);

        $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

        $this->connection->executeQuery($sqlArray[0]);

        echo 'Migrations table created' . PHP_EOL;
    }

    private function getAppliedMigrations(): array
    {
        return $this->connection->executeQuery("SELECT migration FROM migrations;")->fetchFirstColumn();
    }

    private function getMigrationsFiles(): array
    {
        $migrationFiles = scandir($this->migrationsPath);

        return array_filter($migrationFiles, function ($file) {
            return !in_array($file, ['.', '..']);
        });
    }

    private function insertMigration(string $migration): void
    {
        $sql = "INSERT INTO migrations (migration) VALUES (?)";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(1, $migration);

        $stmt->executeStatement();
    }
}