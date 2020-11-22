<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use App\Module\Issue\Infrastructure\Adapter\ProjectTableAdapter;
use App\Module\Issue\Infrastructure\Adapter\UserTableAdapter;
use Doctrine\DBAL\Types\Types;

class IssueListDataMapping
{
    public const ISSUE_ID = 'issue_id';
    public const NAME = 'name';
    public const DESCRIPTION = 'description';
    public const FIELDS = 'fields';
    public const UPDATED_AT = 'updated_at';
    public const USERNAME = UserTableAdapter::USERNAME;
    public const PROJECT_NAME_ID = ProjectTableAdapter::NAME_ID;

    private const TYPES = [
        self::ISSUE_ID => Types::INTEGER,
        self::NAME => Types::STRING,
        self::DESCRIPTION => Types::STRING,
        self::FIELDS => Types::JSON,
        self::UPDATED_AT => Types::DATETIME_IMMUTABLE,
        self::USERNAME => Types::STRING,
        self::PROJECT_NAME_ID => Types::STRING
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