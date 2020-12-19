<?php

namespace App\Module\Assignment\App\Adapter;

use App\Module\Assignment\App\Data\IssueField;
use App\Module\Assignment\App\Exception\FailedToGetIssueFieldsListException;

interface IssueAdapterInterface
{
    /**
     * @param int $projectId
     * @return IssueField[]
     * @throws FailedToGetIssueFieldsListException
     */
    public function getFields(int $projectId): array;
}