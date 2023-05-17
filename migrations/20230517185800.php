<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

return new class
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('posts');

        $table->addColumn('id', Types::INTEGER, [
            'unsigned' => true,
            'autoincrement' => true
        ]);
        $table->addColumn('title', Types::STRING, [
            'length' => 255
        ]);
        $table->addColumn('body', Types::TEXT);
        $table->addColumn('created_add', Types::DATE_IMMUTABLE, [
            'default' => 'CURRENT_TIMESTAMP'
        ]);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('posts');
        // TODO: implement rollback database command
        // doctrine:database:rollback
    }
};