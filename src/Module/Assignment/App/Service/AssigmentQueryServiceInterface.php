<?php

namespace App\Module\Assignment\App\Service;

use App\Module\Assignment\App\Exception\AutoAssigmentNotAvailableException;
use App\Module\Assignment\App\Exception\FailedToGetIssueFieldsListException;

interface AssigmentQueryServiceInterface
{
    /**
     * @param int $projectId
     * @return void
     * @throws AutoAssigmentNotAvailableException
     * @throws FailedToGetIssueFieldsListException
     */
    public function isAutoAssigmentAvailable(int $projectId): void;
}