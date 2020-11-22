<?php

namespace App\Module\Issue\App\Query\Data;

class IssueListItemData
{
    private int $issueId;
    private string $name;
    private ?string $description;
    private ?string $assigneeUsername;
    private ?string $projectNameId;
    private array $fields;
    private \DateTimeImmutable $updatedAt;

    public function __construct(int $issueId, string $name, ?string $description, ?string $assigneeUsername, ?string $projectNameId, array $fields, \DateTimeImmutable $updatedAt)
    {
        $this->issueId = $issueId;
        $this->name = $name;
        $this->description = $description;
        $this->assigneeUsername = $assigneeUsername;
        $this->projectNameId = $projectNameId;
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