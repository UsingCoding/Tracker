<?php

namespace App\Module\Issue\Api\Output;

class GetIssueOutput
{
    private int $issueId;
    private string $name;
    private ?string $description;
    private string $projectName;
    private ?string $username;
    private ?AssigneeUserOutput $assigneeUser;
    private BelongingProjectOutput $project;
    /** @var CommentOutput[] */
    private array $comments;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(int $issueId, string $name, ?string $description, string $projectName, ?string $username, ?AssigneeUserOutput $assigneeUser, BelongingProjectOutput $project, array $comments, \DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAt)
    {
        $this->issueId = $issueId;
        $this->name = $name;
        $this->description = $description;
        $this->projectName = $projectName;
        $this->username = $username;
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
     * @return string
     */
    public function getProjectName(): string
    {
        return $this->projectName;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return AssigneeUserOutput|null
     */
    public function getAssigneeUser(): ?AssigneeUserOutput
    {
        return $this->assigneeUser;
    }

    /**
     * @return BelongingProjectOutput
     */
    public function getProject(): BelongingProjectOutput
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