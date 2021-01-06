<?php

namespace App\Module\Statistics\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;

class UserToIssuesCountHydrator extends AbstractDbalHydrator
{
    /**
     * @param array $row
     * @param array $result
     * @throws \Doctrine\DBAL\Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = [
            $this->convertValue(UserToIssuesCountDataMapping::USERNAME, $row),
            $this->convertValue(UserToIssuesCountDataMapping::ISSUES_COUNT, $row),
        ];
    }

    protected function getColumnType(string $columnName): string
    {
        return UserToIssuesCountDataMapping::getColumnTypeName($columnName);
    }
}