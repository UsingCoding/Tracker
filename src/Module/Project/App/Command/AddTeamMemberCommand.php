<?php

namespace App\Module\Project\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Project\App\Request\AddTeamMemberRequestInterface;

class AddTeamMemberCommand extends AbstractCommand
{
    public const TYPE = 'project.add_team_member';

    public const PROJECT_ID = 'project_id';
    public const USER_ID = 'user_id';

    public function __construct(AddTeamMemberRequestInterface $request)
    {
        parent::__construct([
            self::PROJECT_ID => $request->getProjectId(),
            self::USER_ID => $request->getUserId()
        ]);
    }
}