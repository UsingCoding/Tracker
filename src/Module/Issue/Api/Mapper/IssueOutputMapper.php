<?php

namespace App\Module\Issue\Api\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Api\Output\BelongingProjectOutput;
use App\Module\Issue\Api\Output\GetIssueOutput;
use App\Module\Issue\Api\Output\IssueListItemOutput;
use App\Module\Issue\Api\Output\IssuesListOutput;
use App\Module\Issue\App\Query\Data\IssueData;
use App\Module\Issue\App\Query\Data\IssueListItemData;
use App\Module\Issue\Domain\Service\IssueCodeService;

class IssueOutputMapper
{
    public static function getIssueOutput(IssueData $data): GetIssueOutput
    {
        return new GetIssueOutput(
            $data->getName(),
            $data->getDescription(),
            null,
            new BelongingProjectOutput('formal'),
            [],
            $data->getCreatedAt(),
            $data->getUpdatedAt()
        );
    }

    public static function getIssueListOutput(array $data): IssuesListOutput
    {
        return new IssuesListOutput((array) Arrays::map(
            $data,
            static fn(IssueListItemData $data) =>
            new IssueListItemOutput(
                $data->getIssueId(),
                $data->getName(),
                $data->getDescription(),
                $data->getAssigneeUsername(),
                $data->getProjectNameId(),
                IssueCodeService::getCode($data->getProjectNameId(), $data->getIssueId()),
                $data->getFields(),
                $data->getUpdatedAt()
            ))
        );
    }
}