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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Home
     */
    public function setId(?int $id): Home
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Home
     */
    public function setTitle(string $title): Home
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Home
     */
    public function setBody(string $body): Home
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     * @return Home
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): Home
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}