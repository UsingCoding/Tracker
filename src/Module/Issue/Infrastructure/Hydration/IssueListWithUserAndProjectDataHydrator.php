<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;
use App\Module\Issue\App\Query\Data\IssueListItemData;

class IssueListWithUserAndProjectDataHydrator extends AbstractDbalHydrator
{
    /**
     * @param array $row
     * @param array $result
     * @throws \Doctrine\DBAL\Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = new IssueListItemData(
            $this->convertValue(IssueListDataMapping::ISSUE_ID, $row),
            $this->convertValue(IssueListDataMapping::IN_PROJECT_ID, $row),
            $this->convertValue(IssueListDataMapping::NAME, $row),
            $this->convertValue(IssueListDataMapping::DESCRIPTION, $row),
            $this->convertValue(IssueListDataMapping::USERNAME, $row),
            $this->convertValue(IssueListDataMapping::PROJECT_NAME_ID, $row),
            $this->convertValue(IssueListDataMapping::FIELDS, $row),
            $this->convertValue(IssueListDataMapping::UPDATED_AT, $row),
        );
    }

    protected function getColumnType(string $columnName): string
    {
        return IssueListDataMapping::getColumnTypeName($columnName);
    }
}