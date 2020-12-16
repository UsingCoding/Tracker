<?php

namespace App\Module\Project\Api\Input;

use App\Module\Project\App\Request\AddTeamMemberRequestInterface;

class AddTeamMemberInput implements AddTeamMemberRequestInterface
{
    private int $projectId;
    private int $userId;

    public function __construct(int $projectId, int $userId)
    {
        $this->projectId = $projectId;
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}