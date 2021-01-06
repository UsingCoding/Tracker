<?php

namespace App\Module\Project\Infrastructure\Hydration;

use App\Module\Project\Infrastructure\Adapter\UserTableAdapter;
use Doctrine\DBAL\Types\Types;

class UserToAddToTeamDataMapping
{
    public const USER_ID = UserTableAdapter::USER_ID;
    public const USERNAME = UserTableAdapter::USERNAME;

    private const TYPES = [
        self::USER_ID => Types::INTEGER,
        self::USERNAME => Types::STRING
    ];

    public static function getColumnTypeName(string $columnName): string
    {
        if (!isset(self::TYPES[$columnName]))
        {
            throw new \InvalidArgumentException("Unknown column '$columnName'");
        }

        return self::TYPES[$columnName];
    }
}