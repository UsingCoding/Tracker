<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use App\Module\Issue\Infrastructure\Adapter\ProjectTableAdapter;
use App\Module\Issue\Infrastructure\Adapter\UserTableAdapter;
use Doctrine\DBAL\Types\Types;

class IssueDataMapping
{
    public const ISSUE_ID = 'issue_id';
    public const NAME = 'issue_name';
    public const DESCRIPTION = 'description';
    public const FIELDS = 'fields';
    public const PROJECT_ID = ProjectTableAdapter::PROJECT_ID;
    public const USER_ID = UserTableAdapter::USER_ID;
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const USERNAME = UserTableAdapter::USERNAME;
    public const PROJECT_NAME = 'project_name';
    public const IN_PROJECT_ID = 'in_project_id';

    private const TYPES = [
        self::ISSUE_ID => Types::INTEGER,
        self::NAME => Types::STRING,
        self::DESCRIPTION => Types::STRING,
        self::FIELDS => Types::JSON,
        self::PROJECT_ID => Types::INTEGER,
        self::PROJECT_NAME => Types::STRING,
        self::USER_ID => Types::INTEGER,
        self::USERNAME => Types::STRING,
        self::CREATED_AT => Types::DATETIME_IMMUTABLE,
        self::UPDATED_AT => Types::DATETIME_IMMUTABLE,
        self::IN_PROJECT_ID => Types::INTEGER
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