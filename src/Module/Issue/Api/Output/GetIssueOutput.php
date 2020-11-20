<?php

namespace App\Module\Issue\Api\Output;

class GetIssueOutput
{
    private string $name;
    private ?string $description;
    private ?AssigneeUserOutput $assigneeUser;
    private BelongingProjectOutput $project;
    /** @var CommentOutput[] */
    private array $comments;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(string $name, ?string $description, ?AssigneeUserOutput $assigneeUser, BelongingProjectOutput $project, array $comments, \DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAt)
    {
        $this->name = $name;
        $this->description = $description;
        $this->assigneeUser = $assigneeUser;
        $this->project = $project;
        $this->comments = $comments;
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