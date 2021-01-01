<?php

namespace App\Module\Issue\App\Command;

use App\Common\App\Command\AbstractCommand;

class DeleteCommentCommand extends AbstractCommand
{
    public const TYPE = 'issue.delete_comment';

    public const COMMENT_ID = 'comment_id';

    public function __construct(int $commentId)
    {
        parent::__construct([
            self::COMMENT_ID => $commentId
        ]);
    }
}