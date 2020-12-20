<?php

namespace App\Module\Assignment\Api;

use App\Module\Assignment\Api\Exception\ApiException;

interface ApiInterface
{
    /**
     * @param int $projectId
     * @return bool
     * @throws ApiException
     */
    public function isAutoAssigmentAvailable(int $projectId): bool;

    /**
     * @param int $projectId
     * @return int
     * @throws ApiException
     */
    public function autoAssignIssuesInProject(int $projectId): int;
}