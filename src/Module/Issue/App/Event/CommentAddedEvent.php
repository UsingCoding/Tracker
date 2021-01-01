<?php

namespace App\Module\Issue\App\Event;

use App\Common\App\Event\AppEventInterface;

class CommentAddedEvent implements AppEventInterface
{
    private int $commentId;

    public function __construct(int $commentId)
    {
        $this->commentId = $commentId;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }
}