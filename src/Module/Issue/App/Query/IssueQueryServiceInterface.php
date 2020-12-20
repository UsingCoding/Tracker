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
     * @return IssueListItemData[]
     * @throws SearchQueryParsingException
     * @throws Exception
     */
    public function list(string $query): array;

    /**
     * @param int|null $projectId
     * @return IssueWithFieldsData[]
     * @throws Exception
     */
    public function getIssueForProject(int $projectId): array;
}