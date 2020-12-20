<?php

namespace App\Module\Assignment\App\Data;

class IssueWithFieldsData
{
    private int $issueId;
    private int $projectId;
    /** @var int[] => string[] */
    private array $fields;

    public function __construct(int $issueId, int $projectId, array $fields)
    {
        $this->issueId = $issueId;
        $this->projectId = $projectId;
        $this->fields = $fields;
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
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @return int[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}