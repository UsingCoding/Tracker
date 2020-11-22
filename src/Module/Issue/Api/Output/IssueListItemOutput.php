<?php

namespace App\Module\Issue\Api\Output;

class IssueListItemOutput
{
    private string $name;
    private ?string $description;
    private ?AssigneeUserOutput $assigneeUser;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(string $name, ?string $description, ?AssigneeUserOutput $assigneeUser, \DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAt)
    {
        $this->name = $name;
        $this->description = $description;
        $this->assigneeUser = $assigneeUser;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
     * @return AssigneeUserOutput|null
     */
    public function getAssigneeUser(): ?AssigneeUserOutput
    {
        return $this->assigneeUser;
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