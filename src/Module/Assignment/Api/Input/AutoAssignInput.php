<?php

namespace App\Module\Assignment\Api\Input;

class AutoAssignInput
{
    private int $issueId;
    private int $projectId;

    public function __construct(int $issueId, int $projectId)
    {
        $this->issueId = $issueId;
        $this->projectId = $projectId;
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
}