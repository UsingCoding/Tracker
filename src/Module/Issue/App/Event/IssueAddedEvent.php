<?php

namespace App\Module\Issue\App\Event;

use App\Common\App\Event\AppEventInterface;

class IssueAddedEvent implements AppEventInterface
{
    private int $inProjectId;

    public function __construct(int $issueId)
    {
        $this->inProjectId = $issueId;
    }

    /**
     * @return int
     */
    public function getInProjectId(): int
    {
        return $this->inProjectId;
    }
}