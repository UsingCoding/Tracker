<?php

namespace App\Module\Project\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Project\App\Request\EditProjectRequestInterface;

class EditProjectCommand extends AbstractCommand
{
    public const TYPE = 'project.edit_project';

    public const PROJECT_ID = 'project_id';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';

    public function __construct(EditProjectRequestInterface $request)
    {
        parent::__construct([
            self::PROJECT_ID => $request->getId(),
            self::NAME => $request->getName(),
            self::DESCRIPTION => $request->getDescription()
        ]);
    }
}