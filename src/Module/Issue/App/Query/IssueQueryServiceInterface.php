<?php

namespace App\Module\Issue\App\Query;

use App\Module\Issue\App\Exception\SearchQueryParsingException;
use App\Module\Issue\App\Query\Data\IssueData;
use App\Module\Issue\App\Query\Data\IssueListItemData;
use App\Module\Issue\App\Query\Data\IssueWithFieldsData;
use App\Module\Issue\Domain\Exception\InvalidIssueCodeException;
use Exception;

interface IssueQueryServiceInterface
{
    /**
     * @param string $code
     * @return IssueData|null
     * @throws InvalidIssueCodeException
     * @throws Exception
     */
    public function getIssue(string $code): ?IssueData;

    /**
     * @param string $query
     * @param int $page
     * @param int|null $currentUserId
     * @param int|null $projectId
     * @return IssueListItemData[]
     * @throws SearchQueryParsingException
     * @throws Exception
     */
    public function issuesList(string $query, int $page, ?int $currentUserId, ?int $projectId): array;

    /**
     * @param int|null $projectId
     * @return IssueWithFieldsData[]
     * @throws Exception
     */
    public function getIssueForProject(int $projectId): array;

    /**
     * @param int $userId
     * @return int[]
     */
    public function getIssuesIdAllowedForUserTeamMember(int $userId): array;
}