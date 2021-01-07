<?php

namespace App\Module\Statistics\Api;

use App\Module\Statistics\Api\Exception\ApiException;
use App\Module\Statistics\Api\Output\ProjectStatisticsOutput;

interface ApiInterface
{
    /**
     * @param int $projectId
     * @return ProjectStatisticsOutput
     * @throws ApiException
     */
    public function getProjectStatistics(int $projectId): ProjectStatisticsOutput;
}