<?php

namespace App\Module\Issue\App\Query;

use App\Module\Issue\App\Query\Data\ExtendedIssueData;
use Exception;

class AppIssueQueryService
{
    private IssueQueryServiceInterface $issueQueryService;
    private CommentQueryServiceInterface $commentQueryService;

    public function __construct(IssueQueryServiceInterface $issueQueryService, CommentQueryServiceInterface $commentQueryService)
    {
        $this->issueQueryService = $issueQueryService;
        $this->commentQueryService = $commentQueryService;
    }

    /**
     * @param string $issueId
     * @return ExtendedIssueData
     * @throws Exception
     */
    public function getIssue(string $issueId): ?ExtendedIssueData
    {
        $issue = $this->issueQueryService->getIssue($issueId);

        if ($issue === null)
        {
            return null;
        }

        return new ExtendedIssueData(
            $issue,
            $this->commentQueryService->getCommentsForIssue($issue->getIssueId())
        );
    }
}