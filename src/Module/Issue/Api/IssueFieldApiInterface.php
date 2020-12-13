<?php

namespace App\Module\Issue\Api;

use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\Input\AddIssueFieldInput;
use App\Module\Issue\Api\Input\DeleteIssueFieldInput;
use App\Module\Issue\Api\Input\EditIssueFieldInput;
use App\Module\Issue\Api\Output\IssueFieldListOutput;

interface IssueFieldApiInterface
{
    /**
     * @param AddIssueFieldInput $input
     * @return int
     * @throws ApiException
     */
    public function addIssueField(AddIssueFieldInput $input): int;

    /**
     * @param EditIssueFieldInput $input
     * @throws ApiException
     */
    public function editIssueField(EditIssueFieldInput $input): void;

    /**
     * @param DeleteIssueFieldInput $input
     * @throws ApiException
     */
    public function deleteIssueField(DeleteIssueFieldInput $input): void;

    /**
     * @param int $projectId
     * @return IssueFieldListOutput
     * @throws ApiException
     */
    public function issueFieldListForProject(int $projectId): IssueFieldListOutput;
}