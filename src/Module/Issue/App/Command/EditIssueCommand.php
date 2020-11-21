<?php

namespace App\Module\Issue\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Issue\App\Data\EditIssueRequestInterface;

class EditIssueCommand extends AbstractCommand
{
    public const TYPE = 'issue.edit_issue';

    public const ISSUE_ID = 'issue_id';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';

    public function __construct(EditIssueRequestInterface $request)
    {
        parent::__construct([
            self::ISSUE_ID => $request->getId(),
            self::NAME => $request->getName(),
            self::DESCRIPTION => $request->getDescription()
        ]);
    }
}