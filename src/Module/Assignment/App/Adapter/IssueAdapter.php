<?php

namespace App\Module\Assignment\App\Adapter;

use App\Module\Assignment\App\Adapter\Mapper\IssueFieldMapper;
use App\Module\Assignment\App\Exception\FailedToGetIssueFieldsListException;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\IssueFieldApiInterface;

class IssueAdapter implements IssueAdapterInterface
{
    private IssueFieldApiInterface $issueFieldsApi;

    public function __construct(IssueFieldApiInterface $issueFieldsApi)
    {
        $this->issueFieldsApi = $issueFieldsApi;
    }

    public function getFields(int $projectId): array
    {
        try
        {
            $list = $this->issueFieldsApi->issueFieldListForProject($projectId);

            return IssueFieldMapper::getIssueFieldList($list);
        }
        catch (ApiException $e)
        {
            throw new FailedToGetIssueFieldsListException('', ['project_id' => $projectId]);
        }
    }
}