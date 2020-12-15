<?php

namespace App\Module\User\Infrastructure\Hydration;

use App\Framework\Infrastructure\Hydration\AbstractDbalHydrator;
use App\Module\User\App\Data\UserData;

class UserDataHydrator extends AbstractDbalHydrator
{
    /**
     * @param array $row
     * @param array $result
     * @throws \Doctrine\DBAL\Exception
     */
    public function hydrate(array $row, array &$result): void
    {
        $result[] = new UserData(
            $this->convertValue(UserDataMapping::USER_ID, $row),
            $this->convertValue(UserDataMapping::USERNAME, $row),
            $this->convertValue(UserDataMapping::PASSWORD, $row),
            $this->convertValue(UserDataMapping::CREATED_AT, $row),
            $this->convertValue(UserDataMapping::EMAIL, $row),
            $this->convertValue(UserDataMapping::GRADE, $row),
        );
    }

    protected function getColumnType(string $columnName): string
    {
        return UserDataMapping::getColumnTypeName($columnName);
    }
}