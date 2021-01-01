<?php

namespace App\Module\Issue\App\Command;

use App\Common\App\Command\AbstractCommand;

class DeleteIssueCommand extends AbstractCommand
{
    public const TYPE = 'issue.delete_issue';

    public const ISSUE_ID = 'issue_id';

    public function __construct(int $issueId)
    {
        parent::__construct([
            self::ISSUE_ID => $issueId
        ]);
    }
}