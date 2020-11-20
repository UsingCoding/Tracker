<?php

namespace App\Module\Issue\Domain\Model;

class IssueCode
{
    private string $projectNameId;
    private int $issueId;

    public function __construct(string $projectName, int $issueId)
    {
        $this->projectNameId = $projectName;
        $this->issueId = $issueId;
    }

    public function getProjectNameId(): string
    {
        return $this->projectNameId;
    }

    public function getIssueId(): int
    {
        return $this->issueId;
    }
}