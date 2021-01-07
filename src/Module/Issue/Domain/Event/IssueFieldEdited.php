<?php

namespace App\Module\Issue\Domain\Event;

use App\Common\Domain\Event\DomainEventInterface;

class IssueFieldEdited implements DomainEventInterface
{
    public const TYPE = 'issue_field.edited';

    private int $id;
    private string $name;
    private ?string $newName;
    private ?int $type;
    private int $projectId;

    public function __construct(int $id, string $name, ?string $newName, ?int $type, int $projectId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->newName = $newName;
        $this->type = $type;
        $this->projectId = $projectId;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getNewName(): ?string
    {
        return $this->newName;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getFieldType(): ?int
    {
        return $this->type;
    }
}