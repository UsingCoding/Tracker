<?php

namespace App\Module\Issue\Api\Output;

class IssueFieldListOutput
{
    /** @var IssueFieldOutput[] */
    private array $issuesFields;

    public function __construct(array $issuesFields)
    {
        $this->issuesFields = $issuesFields;
    }

    /**
     * @return IssueFieldOutput[]
     */
    public function getIssuesFields(): array
    {
        return $this->issuesFields;
    }
}