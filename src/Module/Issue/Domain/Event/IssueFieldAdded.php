<?php

namespace App\Module\Issue\Domain\Event;

use App\Common\Domain\Event\DomainEventInterface;

class IssueFieldAdded implements DomainEventInterface
{
    public const TYPE = 'issue_field.added';

    private int $id;
    private string $name;
    private int $type;
    private int $projectId;

    public function __construct(int $id, string $name, int $type, int $projectId)
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getFieldType(): int
    {
        return $this->type;
    }
}