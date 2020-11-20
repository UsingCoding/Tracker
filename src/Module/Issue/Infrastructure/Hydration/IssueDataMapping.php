<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use Doctrine\DBAL\Types\Types;

class IssueDataMapping
{
    public const ISSUE_ID = 'issue_id';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const FIELDS = 'fields';
    public const PROJECT_ID = 'project_id';
    public const USER_ID = 'user_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    private const TYPES = [
        self::ISSUE_ID => Types::INTEGER,
        self::NAME => Types::STRING,
        self::DESCRIPTION => Types::STRING,
        self::FIELDS => Types::JSON,
        self::PROJECT_ID => Types::INTEGER,
        self::USER_ID => Types::INTEGER,
        self::CREATED_AT => Types::DATETIME_IMMUTABLE,
        self::UPDATED_AT => Types::DATETIME_IMMUTABLE
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