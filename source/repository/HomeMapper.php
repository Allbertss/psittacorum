<?php

namespace App\repository;

use App\entity\Home;
use Doctrine\DBAL\Connection;

class HomeMapper
{
    public function __construct(
        private Connection $connection
    )
    {
    }

    public function save(Home $home): int
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO home (title, body, created_at)
                    VALUES (:title, :body, :created_at)"
        );

        $stmt->bindValue(':title', $home->getTitle());
        $stmt->bindValue(':body', $home->getBody());
        $stmt->bindValue(':created_at', $home->getCreatedAt()->format('Y-m-d H:i:s'));

        $stmt->executeStatement();

        $id = $this->connection->lastInsertId();

        $home->setId($id);

        return $id;
    }
}