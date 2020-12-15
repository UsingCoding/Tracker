<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;
use App\Module\Issue\App\Query\Data\IssueFieldListItemData;

class IssueFieldListDataHydrator extends AbstractDbalHydrator
{
    /**
     * @param array $row
     * @param array $result
     * @throws \Doctrine\DBAL\Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = new IssueFieldListItemData(
            $this->convertValue(IssueFieldDataMapping::ISSUE_FIELD_ID, $row),
            $this->convertValue(IssueFieldDataMapping::NAME, $row),
            $this->convertValue(IssueFieldDataMapping::TYPE, $row)
        );
    }

    protected function getColumnType(string $columnName): string
    {
        return IssueFieldDataMapping::getColumnTypeName($columnName);
    }
}