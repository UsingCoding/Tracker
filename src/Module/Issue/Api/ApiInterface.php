<?php

namespace App\Module\Issue\Api;

use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\CreateIssueInput;
use App\Module\Issue\Api\Input\EditIssueInput;
use App\Module\Issue\Api\Output\GetIssueOutput;
use App\Module\Issue\Api\Output\IssuesListOutput;

interface ApiInterface extends IssueFieldApiInterface
{
    /**
     * @param CreateIssueInput $input
     * @return int
     * @throws ApiException
     */
    public function createIssue(CreateIssueInput $input): int;

    /**
     * @param string $code
     * @return GetIssueOutput|null
     * @throws ApiException
     */
    public function getIssue(string $code): ?GetIssueOutput;

    /**
     * @param EditIssueInput $input
     * @throws ApiException
     */
    public function editIssue(EditIssueInput $input): void;

    /**
     * @param int $issueId
     * @throws ApiException
     */
    public function deleteIssue(int $issueId): void;

    /**
     * @param string $query
     * @return IssuesListOutput
     * @throws ApiException
     */
    public function list(string $query): IssuesListOutput;
}