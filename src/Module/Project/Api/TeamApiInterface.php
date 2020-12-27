<?php

namespace App\Module\Project\Api;

use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\AddTeamMemberInput;
use App\Module\Project\Api\Output\TeamMemberListOutput;

interface TeamApiInterface
{
    /**
     * @param AddTeamMemberInput $input
     * @throws ApiException
     */
    public function addMember(AddTeamMemberInput $input): void;

    /**
     * @param int $teamMemberId
     * @throws ApiException
     */
    public function removeMember(int $teamMemberId): void;

    /**
     * @param int $projectId
     * @return TeamMemberListOutput
     * @throws ApiException
     */
    public function teamMemberList(int $projectId): TeamMemberListOutput;
}