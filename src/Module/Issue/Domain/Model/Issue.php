<?php

namespace App\Module\Issue\Domain\Model;

use App\Module\Project\Domain\Model\Project;
use App\Module\User\Domain\Model\User;

class Issue
{
    private ?int $id;
    private string $name;
    private ?string $description;
    private array $fields;
    private ?Project $projectId;
    private ?User $userId;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(?int $id, string $name, ?string $description, array $fields, ?Project $projectId, ?User $userId, \DateTimeImmutable $createdAt, \DateTimeImmutable $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->fields = $fields;
        $this->projectId = $projectId;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return Project|null
     */
    public function getProjectId(): ?Project
    {
        return $this->projectId;
    }

    /**
     * @param Project|null $projectId
     */
    public function setProjectId(?Project $projectId): void
    {
        $this->projectId = $projectId;
    }

    /**
     * @return User|null
     */
    public function getUserId(): ?User
    {
        return $this->userId;
    }

    /**
     * @param User|null $userId
     */
    public function setUserId(?User $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}