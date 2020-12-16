<?php

namespace App\Module\Project\Api;

use App\Module\Project\Api\Exception\ApiException;
use App\Module\Project\Api\Input\AddTeamMemberInput;

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
}