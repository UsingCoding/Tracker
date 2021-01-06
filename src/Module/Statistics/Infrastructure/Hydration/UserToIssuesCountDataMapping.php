<?php

namespace App\Module\Statistics\Infrastructure\Hydration;

use App\Module\Statistics\Infrastructure\Adapter\UserTableAdapter;
use Doctrine\DBAL\Types\Types;

class UserToIssuesCountDataMapping
{
    public const USERNAME = UserTableAdapter::USERNAME;
    public const ISSUES_COUNT = 'issues_count';

    private const TYPES = [
        self::USERNAME => Types::STRING,
        self::ISSUES_COUNT => Types::INTEGER
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