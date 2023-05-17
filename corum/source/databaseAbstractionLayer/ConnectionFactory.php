<?php

namespace allbertss\psittacorum\databaseAbstractionLayer;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class ConnectionFactory
{
    public function __construct(
        private string $databaseUrl
    )
    {
    }

    public function createConnection(): Connection
    {
        return DriverManager::getConnection([
            'url' => $this->databaseUrl
        ]);
    }
}