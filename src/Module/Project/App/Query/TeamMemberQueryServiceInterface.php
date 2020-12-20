<?php

namespace App\Module\Project\App\Query;

use App\Module\Project\App\Data\TeamMemberData;

interface TeamMemberQueryServiceInterface
{
    /**
     * @param int $projectId
     * @return TeamMemberData[]
     * @throws \Exception
     */
    public function getList(int $projectId): array;
}