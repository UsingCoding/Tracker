<?php

namespace App\Module\Issue\Domain\Event;

use App\Common\Domain\Event\DomainEventInterface;

class IssueFieldDeleted implements DomainEventInterface
{
    public const TYPE = 'issue_field.edited';

    private int $id;
    private int $projectId;
    private string $name;

    public function __construct(int $id, int $projectId, string $name)
    {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->name = $name;
    }


    public function getType(): string
    {
        return self::TYPE;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}