<?php

namespace App\Module\Issue\App\Query\Data;

class IssueData
{
    private int $issueId;
    private int $inProjectId;
    private string $name;
    private ?string $description;
    private ?string $username;
    private string $projectName;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(int $issueId, int $inProjectId, string $name, ?string $description, ?string $username, string $projectName, \DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAt)
    {
        $this->issueId = $issueId;
        $this->inProjectId = $inProjectId;
        $this->name = $name;
        $this->description = $description;
        $this->username = $username;
        $this->projectName = $projectName;
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
     * @return int
     */
    public function getInProjectId(): int
    {
        return $this->inProjectId;
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
        return $this->projectName;
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