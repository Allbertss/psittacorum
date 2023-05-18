<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

return new class {
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('users');

        $table->addColumn('id', Types::INTEGER, [
            'unsigned' => true,
            'autoincrement' => true
        ]);
        $table->addColumn('username', Types::STRING, [
            'length' => 255
        ]);
        $table->addColumn('password', Types::STRING, [
            'length' => 255
        ]);
        $table->addColumn('created_at', Types::DATE_IMMUTABLE, [
            'default' => 'CURRENT_TIMESTAMP'
        ]);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('users')) {
            $schema->dropTable('users');
        }
    }
};