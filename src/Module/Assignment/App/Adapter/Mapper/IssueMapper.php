<?php

namespace App\Module\Assignment\App\Adapter\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Assignment\App\Data\IssueWithFieldsData;
use App\Module\Issue\App\Query\Data\IssueWithFieldsData as IssueData;

class IssueMapper
{
    /**
     * @param IssueData[] $list
     * @return IssueWithFieldsData[]
     */
    public static function getIssues(array $list): array
    {
        return (array) Arrays::map($list,
            static fn(IssueData $data) => self::getIssue($data)
        );
    }

    public static function getIssue(IssueData $data): IssueWithFieldsData
    {
        return new IssueWithFieldsData(
            $data->getId(),
            $data->getProjectId(),
            $data->getFields()
        );
    }
}