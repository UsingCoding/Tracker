<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;
use App\Module\Issue\App\Query\Data\IssueWithFieldsData;

class IssueWithFieldsHydrator extends AbstractDbalHydrator
{
    /**
     * @param array $row
     * @param array $result
     * @throws \Doctrine\DBAL\Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = new IssueWithFieldsData(
            $this->convertValue(IssueDataMapping::ISSUE_ID, $row),
            $this->convertValue(IssueDataMapping::PROJECT_ID, $row),
            $this->convertValue(IssueDataMapping::FIELDS, $row)
        );
    }

    protected function getColumnType(string $columnName): string
    {
        return IssueDataMapping::getColumnTypeName($columnName);
    }
}