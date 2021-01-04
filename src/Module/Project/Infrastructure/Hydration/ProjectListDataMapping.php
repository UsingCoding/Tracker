<?php

namespace App\Module\Project\Infrastructure\Hydration;

use Doctrine\DBAL\Types\Types;

class ProjectListDataMapping
{
    public const PROJECT_ID = 'project_id';
    public const NAME = 'name';
    public const NAME_ID = 'name_id';
    public const OWNER_ID = 'owner_id';
    public const DESCRIPTION = 'description';

    private const TYPES = [
        self::PROJECT_ID => Types::INTEGER,
        self::NAME => Types::STRING,
        self::NAME_ID => Types::STRING,
        self::OWNER_ID => Types::INTEGER,
        self::DESCRIPTION => Types::STRING
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