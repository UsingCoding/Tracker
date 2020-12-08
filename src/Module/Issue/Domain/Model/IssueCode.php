<?php

namespace App\Module\Issue\Domain\Model;

class IssueCode
{
    private string $projectNameId;
    private int $issueInProjectId;

    public function __construct(string $projectName, int $issueId)
    {
        $this->projectNameId = $projectName;
        $this->issueInProjectId = $issueId;
    }

    public function getProjectNameId(): string
    {
        return $this->projectNameId;
    }

    public function getIssueInProjectId(): int
    {
        return $this->issueInProjectId;
    }
}