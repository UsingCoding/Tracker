<?php

namespace App\Module\Issue\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Issue\App\Data\AddIssueFieldRequestInterface;

class AddIssueFieldCommand extends AbstractCommand
{
    public const TYPE = 'issue.add_field';

    public const NAME = 'name';
    public const FIELD_TYPE = 'type';
    public const PROJECT_ID = 'project_id';

    public function __construct(AddIssueFieldRequestInterface $request)
    {
        parent::__construct([
            self::NAME => $request->getName(),
            self::FIELD_TYPE => $request->getType(),
            self::PROJECT_ID => $request->getProjectId()
        ]);
    }
}