<?php

namespace App\Module\Project\App\Command;

use App\Common\App\Command\AbstractCommand;

class RemoveTeamMemberCommand extends AbstractCommand
{
    public const TYPE = 'project.remove_team_member';

    public const TEAM_MEMBER_ID = 'team_member_id';

    public function __construct(int $teamMemberId)
    {
        parent::__construct([self::TEAM_MEMBER_ID => $teamMemberId]);
    }
}