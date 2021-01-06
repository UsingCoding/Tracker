<?php

namespace App\Module\Statistics\App\Data;

class ProjectStatisticsData
{
    private array $userToIssuesCountMap;

    public function __construct(array $userToIssuesCountMap)
    {
        $this->userToIssuesCountMap = $userToIssuesCountMap;
    }

    /**
     * @return array
     */
    public function getUserToIssuesCountMap(): array
    {
        return $this->userToIssuesCountMap;
    }
}