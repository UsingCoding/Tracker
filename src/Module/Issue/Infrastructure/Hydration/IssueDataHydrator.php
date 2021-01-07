<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;
use App\Module\Issue\App\Query\Data\IssueData;

class IssueDataHydrator extends AbstractDbalHydrator
{
    /**
     * @param array $row
     * @param array $result
     * @throws \Doctrine\DBAL\Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = new IssueData(
            $this->convertValue(IssueDataMapping::ISSUE_ID, $row),
            $this->convertValue(IssueDataMapping::IN_PROJECT_ID, $row),
            $this->convertValue(IssueDataMapping::NAME, $row),
            $this->convertValue(IssueDataMapping::DESCRIPTION, $row),
            $this->convertValue(IssueDataMapping::FIELDS, $row),
            $this->convertValue(IssueDataMapping::USER_ID, $row),
            $this->convertValue(IssueDataMapping::USERNAME, $row),
            $this->convertValue(IssueDataMapping::PROJECT_ID, $row),
            $this->convertValue(IssueDataMapping::PROJECT_NAME, $row),
            $this->convertValue(IssueDataMapping::CREATED_AT, $row),
            $this->convertValue(IssueDataMapping::UPDATED_AT, $row)
        );
    }

    protected function getColumnType(string $columnName): string
    {
        return IssueDataMapping::getColumnTypeName($columnName);
    }
}