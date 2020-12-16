<?php

namespace App\Module\Project\App\Command;

use App\Common\App\Command\AbstractCommand;

class DeleteProjectCommand extends AbstractCommand
{
    public const TYPE = 'project.delete_project';

    public const PROJECT_ID = 'project_id';

    public function __construct(int $projectId)
    {
        parent::__construct([self::PROJECT_ID => $projectId]);
    }
}