<?php

namespace App\Module\Assignment\App\Adapter;

use App\Module\Assignment\App\Adapter\Mapper\IssueFieldMapper;
use App\Module\Assignment\App\Adapter\Mapper\IssueMapper;
use App\Module\Assignment\App\Exception\FailedToGetIssueFieldsListException;
use App\Module\Assignment\App\Exception\IssueInternalException;
use App\Module\Issue\Api\Exception\ApiException;
use App\Module\Issue\Api\IssueFieldApiInterface;
use App\Module\Issue\App\Query\IssueQueryServiceInterface;

class IssueAdapter implements IssueAdapterInterface
{
    private IssueFieldApiInterface $issueFieldsApi;
    private IssueQueryServiceInterface $issueQueryService;

    public function __construct(IssueFieldApiInterface $issueFieldsApi, IssueQueryServiceInterface $issueQueryService)
    {
        $this->issueFieldsApi = $issueFieldsApi;
        $this->issueQueryService = $issueQueryService;
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

    public function findIssuesForProject(int $projectId): array
    {
        try
        {
            return IssueMapper::getIssues($this->issueQueryService->getIssueForProject($projectId));
        }
        catch (\Exception $exception)
        {
            throw new IssueInternalException($exception->getMessage(), [], $exception->getCode(), $exception);
        }
    }
}