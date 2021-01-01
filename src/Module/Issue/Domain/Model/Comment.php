<?php

namespace App\Module\Issue\Domain\Model;

class Comment
{
    private ?int $id;
    private int $issueId;
    private int $userId;
    private string $content;

    public function __construct(?int $id, int $issueId, int $userId, string $content)
    {
        $this->id = $id;
        $this->issueId = $issueId;
        $this->userId = $userId;
        $this->content = $content;
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
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getIssueId(): int
    {
        return $this->issueId;
    }

    /**
     * @param int $issueId
     */
    public function setIssueId(int $issueId): void
    {
        $this->issueId = $issueId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}