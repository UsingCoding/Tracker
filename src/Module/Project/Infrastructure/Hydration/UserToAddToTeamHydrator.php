<?php

namespace App\Module\Project\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;
use App\Module\Project\App\Data\UserToAddToTeamData;

class UserToAddToTeamHydrator extends AbstractDbalHydrator
{

    /**
     * @param array $row
     * @param array $result
     * @throws \Doctrine\DBAL\Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = new UserToAddToTeamData(
            $this->convertValue(UserToAddToTeamDataMapping::USER_ID, $row),
            $this->convertValue(UserToAddToTeamDataMapping::USERNAME, $row),
        );
    }

    protected function getColumnType(string $columnName): string
    {
        return UserToAddToTeamDataMapping::getColumnTypeName($columnName);
    }
}