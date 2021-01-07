<?php

namespace App\Module\Statistics\Api;

use App\Module\Statistics\Api\Exception\ApiException;
use App\Module\Statistics\Api\Output\ProjectStatisticsOutput;
use App\Module\Statistics\App\Service\ProjectStatisticsServiceInterface;

class Api implements ApiInterface
{
    private ProjectStatisticsServiceInterface $projectStatisticsService;

    public function __construct(ProjectStatisticsServiceInterface $projectStatisticsService)
    {
        $this->projectStatisticsService = $projectStatisticsService;
    }

    public function getProjectStatistics(int $projectId): ProjectStatisticsOutput
    {
        try
        {
            $data = $this->projectStatisticsService->getProjectStatistics($projectId);

            return new ProjectStatisticsOutput($data->getUserToIssuesCountMap());
        }
        catch (\Throwable $throwable)
        {
            throw ApiException::from($throwable);
        }
    }
}