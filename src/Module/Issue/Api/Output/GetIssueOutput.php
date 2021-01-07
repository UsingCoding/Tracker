<?php

namespace App\Module\Issue\Api\Output;

class GetIssueOutput
{
    private int $issueId;
    private int $inProjectId;
    private string $name;
    private ?string $description;
    private array $fields;
    private ?AssigneeUserOutput $assigneeUser;
    private ProjectOutput $project;
    /** @var CommentOutput[] */
    private array $comments;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(int $issueId, int $inProjectId, string $name, ?string $description, array $fields, ?AssigneeUserOutput $assigneeUser, ProjectOutput $project, array $comments, \DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAt)
    {
        $this->issueId = $issueId;
        $this->inProjectId = $inProjectId;
        $this->name = $name;
        $this->description = $description;
        $this->fields = $fields;
        $this->assigneeUser = $assigneeUser;
        $this->project = $project;
        $this->comments = $comments;
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
     * @return AssigneeUserOutput|null
     */
    public function getAssigneeUser(): ?AssigneeUserOutput
    {
        return $this->assigneeUser;
    }

    /**
     * @return ProjectOutput
     */
    public function getProject(): ProjectOutput
    {
        return $this->project;
    }

    /**
     * @return CommentOutput[]
     */
    public function getComments(): array
    {
        return $this->comments;
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