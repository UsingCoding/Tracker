<?php

namespace App\Module\Assignment\App\Adapter\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Assignment\App\Data\IssueField;
use App\Module\Issue\Api\Output\IssueFieldListOutput;
use App\Module\Issue\Api\Output\IssueFieldOutput;

class IssueFieldMapper
{
    /**
     * @param IssueFieldListOutput $list
     * @return IssueField[]
     */
    public static function getIssueFieldList(IssueFieldListOutput $list): array
    {
        return (array) Arrays::map($list->getIssuesFields(),
            static fn(IssueFieldOutput $output) => new IssueField(
                $output->getId(),
                $output->getName(),
                $output->getType()
            )
        );
    }
}