<?php

namespace App\Module\Statistics\Api\Output;

class ProjectStatisticsOutput
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