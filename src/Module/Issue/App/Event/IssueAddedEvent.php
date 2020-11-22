<?php

namespace App\Module\Issue\App\Event;

use App\Common\App\Event\AppEventInterface;

class IssueAddedEvent implements AppEventInterface
{
    private int $issueId;

    public function __construct(int $issueId)
    {
        $this->issueId = $issueId;
    }

    /**
     * @return int
     */
    public function getIssueId(): int
    {
        return $this->issueId;
    }
}