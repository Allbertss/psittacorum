<?php

namespace App\entity;

class Home
{
    public function __construct(
        private ?int               $id,
        private string             $title,
        private string             $body,
        private \DateTimeImmutable $createdAt
    )
    {
    }

    public static function create(
        string              $title,
        string              $body,
        ?\DateTimeImmutable $createdAt = null,
        ?int                $id = null
    ): Home
    {
        return new self(
            $id,
            $title,
            $body,
            $createdAt ?? new \DateTimeImmutable()
        );
    }
}