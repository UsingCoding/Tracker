<?php

namespace App\Module\Issue\Api\Input;

use App\Module\Issue\App\Data\DeleteIssueFieldRequestInterface;

class DeleteIssueFieldInput implements DeleteIssueFieldRequestInterface
{
    private int $issueFieldId;

    public function __construct(int $issueFieldId)
    {
        $this->issueFieldId = $issueFieldId;
    }

    public function getIssueFieldId(): int
    {
        return $this->issueFieldId;
    }
}