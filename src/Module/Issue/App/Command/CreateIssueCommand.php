<?php

namespace App\Module\Issue\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Issue\App\Data\CreateIssueRequestInterface;

class CreateIssueCommand extends AbstractCommand
{
    public const TYPE = 'issue.create_issue';

    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const FIELDS = 'fields';

    public function __construct(CreateIssueRequestInterface $request)
    {
        parent::__construct([
            self::NAME => $request->getName(),
            self::DESCRIPTION => $request->getDescription(),
            self::FIELDS => $request->getFields(),
        ]);
    }
}