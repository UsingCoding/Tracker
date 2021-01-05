<?php

namespace App\Module\Project\App\Command;

use App\Common\App\Command\AbstractCommand;

class DeleteProjectCommand extends AbstractCommand
{
    public const TYPE = 'project.delete_project';

    public const PROJECT_ID = 'project_id';
    public const OWNER_ID = 'owner_id';

    public function __construct(int $projectId, int $ownerId)
    {
        parent::__construct([
            self::PROJECT_ID => $projectId,
            self::OWNER_ID => $ownerId
        ]);
    }
}