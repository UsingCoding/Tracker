<?php

namespace App\Module\Project\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;
use App\Module\Project\App\Data\TeamMemberData;

class TeamMemberDataHydrator extends AbstractDbalHydrator
{
    /**
     * @param array $row
     * @param array $result
     * @throws \Doctrine\DBAL\Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = new TeamMemberData(
            $this->convertValue(TeamMemberDataMapping::TEAM_MEMBER_ID, $row),
            $this->convertValue(TeamMemberDataMapping::USER_ID, $row),
            $this->convertValue(TeamMemberDataMapping::USERNAME, $row),
        );
    }

    protected function getColumnType(string $columnName): string
    {
        return TeamMemberDataMapping::getColumnTypeName($columnName);
    }
}