<?php

namespace App\Module\Issue\App\Query;

use App\Common\App\Context\LoggedUserIdProviderInterface;
use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\App\Exception\SearchQueryParsingException;
use App\Module\Issue\App\Query\Data\ExtendedIssueData;
use App\Module\Issue\App\Query\Data\IssueListItemData;
use Exception;

class AppIssueQueryService
{
    private IssueQueryServiceInterface $issueQueryService;
    private CommentQueryServiceInterface $commentQueryService;
    private LoggedUserIdProviderInterface $loggedUserIdProvider;

    public function __construct(IssueQueryServiceInterface $issueQueryService, CommentQueryServiceInterface $commentQueryService, LoggedUserIdProviderInterface $loggedUserIdProvider)
    {
        $this->issueQueryService = $issueQueryService;
        $this->commentQueryService = $commentQueryService;
        $this->loggedUserIdProvider = $loggedUserIdProvider;
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

    /**
     * @param string $query
     * @param int $page
     * @param int|null $currentUserId
     * @param int|null $projectId
     * @return IssueListItemData[]
     * @throws SearchQueryParsingException
     * @throws Exception
     */
    public function issuesList(string $query, int $page, ?int $currentUserId, ?int $projectId): array
    {
        $issues = $this->issueQueryService->issuesList($query, $page, null, $projectId);

        $allowedIds = $this->issueQueryService->getIssuesIdAllowedForUserTeamMember($this->loggedUserIdProvider->getUserId());

        return array_filter($issues, static fn(IssueListItemData $data) => Arrays::hasValue($allowedIds, $data->getIssueId()));
    }
}