<?php

namespace App\Module\Project\Infrastructure\Hydration;

use App\Module\Project\Infrastructure\Adapter\UserTableAdapter;
use Doctrine\DBAL\Types\Types;

class TeamMemberDataMapping
{
    public const TEAM_MEMBER_ID = 'team_member_id';
    public const USER_ID = 'user_id';
    public const PROJECT_ID = 'project_id';
    public const USERNAME = UserTableAdapter::USERNAME;

    private const TYPES = [
        self::TEAM_MEMBER_ID => Types::INTEGER,
        self::USER_ID => Types::INTEGER,
        self::PROJECT_ID => Types::INTEGER,
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