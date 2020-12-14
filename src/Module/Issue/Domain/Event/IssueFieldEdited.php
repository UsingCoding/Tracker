<?php

namespace App\Module\Issue\Domain\Event;

use App\Common\Domain\Event\DomainEventInterface;

class IssueFieldEdited implements DomainEventInterface
{
    private const TYPE = 'issue_field.edited';

    private int $id;
    private ?string $name;
    private ?int $type;
    private int $projectId;

    public function __construct(int $id, ?string $name, ?int $type, int $projectId)
    {
        $this->id = $id;
        $this->name = $name;
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function getFieldType(): ?int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }
}