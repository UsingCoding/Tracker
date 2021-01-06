<?php

namespace App\Module\Project\App\Query;

use App\Module\Project\App\Data\TeamMemberData;
use App\Module\Project\App\Data\UserToAddToTeamData;
use Exception;

interface TeamMemberQueryServiceInterface
{
    /**
     * @param int $projectId
     * @return TeamMemberData[]
     * @throws Exception
     */
    public function getList(int $projectId): array;

    /**
     * @param int $projectId
     * @return UserToAddToTeamData[]
     * @throws Exception
     */
    public function getUsersToAddTeamList(int $projectId): array;
}