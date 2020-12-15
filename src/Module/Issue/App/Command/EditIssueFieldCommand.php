<?php

namespace App\Module\Issue\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Issue\App\Data\EditIssueFieldRequestInterface;

class EditIssueFieldCommand extends AbstractCommand
{
    public const TYPE = 'issue.edit_field';

    public const ISSUE_FIELD_ID = 'issue_field_id';
    public const NAME = 'name';
    public const FIELD_TYPE = 'type';

    public function __construct(EditIssueFieldRequestInterface $request)
    {
        parent::__construct([
            self::ISSUE_FIELD_ID => $request->getIssueFieldId(),
            self::NAME => $request->getName(),
            self::FIELD_TYPE => $request->getType(),
        ]);
    }
}