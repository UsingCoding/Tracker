<?php

namespace App\Module\Issue\App\Query\Data;

class IssueData
{
    private int $issueId;
    private int $inProjectId;
    private string $name;
    private ?string $description;
    private array $fields;
    private ?int $userId;
    private ?string $username;
    private int $projectId;
    private string $projectName;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(int $issueId, int $inProjectId, string $name, ?string $description, array $fields, ?int $userId, ?string $username, int $projectId, string $projectName, \DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAt)
    {
        $this->issueId = $issueId;
        $this->inProjectId = $inProjectId;
        $this->name = $name;
        $this->description = $description;
        $this->fields = $fields;
        $this->userId = $userId;
        $this->username = $username;
        $this->projectId = $projectId;
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
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
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