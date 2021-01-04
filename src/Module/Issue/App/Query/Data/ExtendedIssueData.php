<?php

namespace App\Module\Issue\App\Query\Data;

class ExtendedIssueData
{
    private IssueData $issue;
    /** @var CommentData[] */
    private array $comments;

    public function __construct(IssueData $issue, array $comments)
    {
        $this->issue = $issue;
        $this->comments = $comments;
    }

    /**
     * @return IssueData
     */
    public function getIssue(): IssueData
    {
        return $this->issue;
    }

    /**
     * @return CommentData[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }
}