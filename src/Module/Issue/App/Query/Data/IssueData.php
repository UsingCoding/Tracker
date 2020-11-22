<?php

namespace App\Module\Issue\App\Query\Data;

class IssueData
{
    private int $issueId;
    private string $name;
    private ?string $description;
    private ?string $username;
    private string $projectNameId;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(int $issueId, string $name, ?string $description, ?string $username, string $projectNameId, \DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAt)
    {
        $this->issueId = $issueId;
        $this->name = $name;
        $this->description = $description;
        $this->username = $username;
        $this->projectNameId = $projectNameId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getIssueId(): int
    {
        return $this->issueId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getProjectName(): string
    {
        return $this->projectNameId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}