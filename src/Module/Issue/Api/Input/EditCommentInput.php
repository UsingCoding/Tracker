<?php

namespace App\Module\Issue\Api\Input;

use App\Module\Issue\App\Data\EditCommentRequestInterface;

class EditCommentInput implements EditCommentRequestInterface
{
    private int $commentId;
    private string $content;

    public function __construct(int $commentId, string $content)
    {
        $this->commentId = $commentId;
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}