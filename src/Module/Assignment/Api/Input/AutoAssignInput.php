<?php

namespace App\Module\Assignment\Api\Input;

use App\Module\Assignment\App\Data\AutoAssignSpecificationInterface;

class AutoAssignInput implements AutoAssignSpecificationInterface
{
    private ?int $issueId;
    private ?int $projectId;

    public function __construct(?int $issueId, ?int $projectId)
    {
        $this->issueId = $issueId;
        $this->projectId = $projectId;
    }

    /**
     * @return int|null
     */
    public function getIssueId(): ?int
    {
        return $this->issueId;
    }

    /**
     * @return int|null
     */
    public function getProjectId(): ?int
    {
        return $this->projectId;
    }
}