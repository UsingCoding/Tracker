<?php

namespace App\Module\Issue\Api\Output;

class IssueListItemOutput
{
    private int $issueId;
    private int $inProjectId;
    private string $name;
    private ?string $description;
    private ?string $assigneeUsername;
    private ?string $projectNameId;
    private ?string $issueCode;
    private array $fields;
    private \DateTimeImmutable $updatedAt;

    public function __construct(int $issueId, int $inProjectId, string $name, ?string $description, ?string $assigneeUsername, ?string $projectNameId, ?string $issueCode, array $fields, \DateTimeImmutable $updatedAt)
    {
        $this->issueId = $issueId;
        $this->inProjectId = $inProjectId;
        $this->name = $name;
        $this->description = $description;
        $this->assigneeUsername = $assigneeUsername;
        $this->projectNameId = $projectNameId;
        $this->issueCode = $issueCode;
        $this->fields = $fields;
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
    public function getAssigneeUsername(): ?string
    {
        return $this->assigneeUsername;
    }

    /**
     * @return string|null
     */
    public function getProjectNameId(): ?string
    {
        return $this->projectNameId;
    }

    /**
     * @return string|null
     */
    public function getIssueCode(): ?string
    {
        return $this->issueCode;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}