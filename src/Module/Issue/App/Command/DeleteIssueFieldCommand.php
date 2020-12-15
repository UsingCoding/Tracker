<?php

namespace App\Module\Issue\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Issue\App\Data\DeleteIssueFieldRequestInterface;

class DeleteIssueFieldCommand extends AbstractCommand
{
    public const TYPE = 'issue.delete_issue_field';

    public const ISSUE_FIELD_ID = 'issue_field_id';

    public function __construct(DeleteIssueFieldRequestInterface $request)
    {
        parent::__construct([
            self::ISSUE_FIELD_ID => $request->getIssueFieldId()
        ]);
    }
}