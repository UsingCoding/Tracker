<?php

namespace App\Module\Assignment\Api;

use App\Module\Assignment\Api\Exception\ApiException;
use App\Module\Assignment\Api\Input\AutoAssignInput;

interface ApiInterface
{
    /**
     * @param int $projectId
     * @return bool
     * @throws ApiException
     */
    public function isAutoAssigmentAvailable(int $projectId): bool;

    /**
     * @param AutoAssignInput $input
     * @throws ApiException
     */
    public function autoAssign(AutoAssignInput $input): void;
}