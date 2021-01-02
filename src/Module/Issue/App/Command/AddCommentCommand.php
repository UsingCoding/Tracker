<?php

namespace App\Module\Issue\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Issue\App\Data\AddCommentRequestInterface;

class AddCommentCommand extends AbstractCommand
{
    public const TYPE = 'issue.add_comment';

    public const ISSUE_ID = 'issue_id';
    public const USER_ID = 'user_id';
    public const CONTENT = 'content';

    public function __construct(AddCommentRequestInterface $request)
    {
        parent::__construct([
            self::ISSUE_ID => $request->getIssueId(),
            self::USER_ID => $request->getUserId(),
            self::CONTENT => $request->getContent()
        ]);
    }
}