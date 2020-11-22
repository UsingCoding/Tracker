<?php

namespace App\Module\Issue\Api\Mapper;

use App\Module\Issue\Api\Output\BelongingProjectOutput;
use App\Module\Issue\Api\Output\GetIssueOutput;
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
}