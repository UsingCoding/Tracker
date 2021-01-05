<?php

namespace App\Module\Issue\App\Command;

use App\Common\App\Command\AbstractCommand;
use App\Module\Issue\App\Data\EditCommentRequestInterface;

class EditCommentCommand extends AbstractCommand
{
    public const TYPE = 'issue.edit_comment';

    public const COMMENT_ID = 'comment_id';
    public const CONTENT = 'content';

    public function __construct(EditCommentRequestInterface $request)
    {
        parent::__construct([
            self::COMMENT_ID => $request->getCommentId(),
            self::CONTENT => $request->getContent()
        ]);
    }
}