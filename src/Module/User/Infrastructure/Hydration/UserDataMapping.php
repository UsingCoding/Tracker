<?php

namespace App\Module\User\Infrastructure\Hydration;

use App\Module\User\Infrastructure\Query\UserTable;
use Doctrine\DBAL\Types\Types;

class UserDataMapping
{
    public const USER_ID = UserTable::USER_ID;
    public const USERNAME = UserTable::USERNAME;
    public const PASSWORD = UserTable::PASSWORD;
    public const CREATED_AT = UserTable::CREATED_AT;
    public const EMAIL = UserTable::EMAIL;
    public const GRADE = UserTable::GRADE;

    private const TYPES = [
        self::USER_ID => Types::INTEGER,
        self::USERNAME => Types::STRING,
        self::PASSWORD => Types::STRING,
        self::CREATED_AT => Types::DATETIME_IMMUTABLE,
        self::EMAIL => Types::STRING,
        self::GRADE => Types::SMALLINT,
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