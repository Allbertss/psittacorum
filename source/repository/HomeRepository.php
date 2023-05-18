<?php

namespace App\repository;

use App\entity\Home;
use Doctrine\DBAL\Connection;

class HomeRepository
{
    public function __construct(
        private Connection $connection
    )
    {
    }

    public function findById(int $id): Home|null
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('id', 'title', 'body', 'created_at')
            ->from('home')
            ->where('id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->executeQuery();

        $row = $result->fetchAssociative();

        if (!$row) {
            return null;
        }

        return Home::create(
            id: $row['id'],
            title: $row['title'],
            body: $row['body'],
            createdAt: new \DateTimeImmutable($row['created_at'])
        );
    }

    // TODO: check if it is better to return nulls or empty object
    public function findAll(): array|null
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('id', 'title', 'body', 'created_at')
            ->from('home');

        $result = $queryBuilder->executeQuery();

        $rows = $result->fetchAllAssociative();

        if (!$rows) {
            return null;
        }

        return array_map(
            function ($row) {
                return Home::create(
                    id: $row['id'],
                    title: $row['title'],
                    body: $row['body'],
                    createdAt: new \DateTimeImmutable($row['created_at'])
                );
            },
            $rows
        );
    }
}