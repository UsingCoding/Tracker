<?php

namespace App\Module\Issue\App\Event;

use App\Common\App\Event\AppEventInterface;

class IssueFieldAddedEvent implements AppEventInterface
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