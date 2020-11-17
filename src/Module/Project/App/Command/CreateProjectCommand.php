<?php

namespace App\Module\Project\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Project\App\Request\CreateProjectRequestInterface;

class CreateProjectCommand extends AbstractCommand
{
    public const TYPE = 'project.create_project';

    public const NAME = 'name';
    public const NAME_ID = 'name_id';
    public const DESCRIPTION = 'description';

    public function __construct(CreateProjectRequestInterface $request)
    {
        parent::__construct([
            self::NAME => $request->getName(),
            self::NAME_ID => $request->getNameId(),
            self::DESCRIPTION => $request->getDescription()
        ]);
    }
}