<?php

namespace App\Module\Issue\Api\Output;

class CommentOutput
{
    private string $authorName;
    private string $description;
    private \DateTimeImmutable $updatedAt;

    public function __construct(string $authorName, string $description, \DateTimeImmutable $updatedAt)
    {
        $this->authorName = $authorName;
        $this->description = $description;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}