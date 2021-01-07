<?php

namespace App\Module\Statistics\App\Service;

use App\Module\Statistics\App\Data\ProjectStatisticsData;
use Exception;

interface ProjectStatisticsServiceInterface
{
    /**
     * @param int $projectId
     * @return ProjectStatisticsData
     * @throws Exception
     */
    public function getProjectStatistics(int $projectId): ProjectStatisticsData;
}