<?php

namespace App\Module\Issue\Api\Input;

use App\Module\Issue\App\Data\AddCommentRequestInterface;

class AddCommentInput implements AddCommentRequestInterface
{
    private int $issueId;
    private int $userId;
    private string $content;

    public function __construct(int $issueId, int $userId, string $content)
    {
        $this->issueId = $issueId;
        $this->userId = $userId;
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getIssueId(): int
    {
        return $this->issueId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}