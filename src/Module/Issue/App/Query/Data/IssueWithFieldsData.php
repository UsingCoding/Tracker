<?php

namespace App\Module\Issue\App\Query\Data;

class IssueWithFieldsData
{
    private int $id;
    private int $projectId;
    /** @var string[] => string  */
    private array $fields;

    public function __construct(int $id, int $projectId, array $fields)
    {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->fields = $fields;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @return string[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}