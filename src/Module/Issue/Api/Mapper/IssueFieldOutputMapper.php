<?php

namespace App\Module\Issue\Api\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Api\Output\IssueFieldListOutput;
use App\Module\Issue\Api\Output\IssueFieldOutput;
use App\Module\Issue\App\Query\Data\IssueFieldListItemData;

class IssueFieldOutputMapper
{
    /**
     * @param IssueFieldListItemData[] $issueFieldListData
     * @return IssueFieldListOutput
     */
    public static function getIssueFieldListOutput(array $issueFieldListData): IssueFieldListOutput
    {
        return new IssueFieldListOutput((array) Arrays::map($issueFieldListData,
            fn(IssueFieldListItemData $data) => new IssueFieldOutput(
                $data->getId(),
                $data->getName(),
                $data->getType()
            )));
    }
}