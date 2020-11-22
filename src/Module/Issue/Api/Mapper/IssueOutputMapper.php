<?php

namespace App\Module\Issue\Api\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Api\Output\BelongingProjectOutput;
use App\Module\Issue\Api\Output\GetIssueOutput;
use App\Module\Issue\Api\Output\IssueListItemOutput;
use App\Module\Issue\Api\Output\IssuesListOutput;
use App\Module\Issue\App\Query\Data\IssueData;

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
            static fn(IssueData $data) =>
            new IssueListItemOutput(
                $data->getName(),
                $data->getDescription(),
                null,
                $data->getCreatedAt(),
                $data->getUpdatedAt()
            ))
        );
    }
}