<?php

namespace App\Module\Issue\App\Query;

use App\Module\Issue\App\Query\Data\IssueFieldListItemData;

interface IssueFieldQueryServiceInterface
{
    /**
     * @param int $projectId
     * @return IssueFieldListItemData[]
     * @throws \Exception
     */
    public function listForProject(int $projectId): array;
}