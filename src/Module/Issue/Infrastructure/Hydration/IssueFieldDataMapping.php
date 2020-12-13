<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use Doctrine\DBAL\Types\Types;

class IssueFieldDataMapping
{
    public const ISSUE_FIELD_ID = 'issue_id';
    public const NAME = 'name';
    public const TYPE = 'type';

    private const TYPES = [
        self::ISSUE_FIELD_ID => Types::INTEGER,
        self::NAME => Types::STRING,
        self::TYPE => Types::INTEGER
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