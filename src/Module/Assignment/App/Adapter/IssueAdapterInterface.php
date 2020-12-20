<?php

namespace App\Module\Assignment\App\Adapter;

use App\Module\Assignment\App\Data\IssueField;
use App\Module\Assignment\App\Data\IssueWithFieldsData;
use App\Module\Assignment\App\Exception\FailedToGetIssueFieldsListException;
use App\Module\Assignment\App\Exception\IssueInternalException;

interface IssueAdapterInterface
{
    /**
     * @param int $projectId
     * @return IssueField[]
     * @throws FailedToGetIssueFieldsListException
     */
    public function getFields(int $projectId): array;

    /**
     * @param int|null $projectId
     * @return IssueWithFieldsData[]
     * @throws IssueInternalException
     */
    public function findIssuesForProject(int $projectId): array;
}