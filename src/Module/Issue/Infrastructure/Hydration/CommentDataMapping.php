<?php

namespace App\Module\Issue\Infrastructure\Hydration;

use App\Module\Issue\Infrastructure\Adapter\UserTableAdapter;
use Doctrine\DBAL\Types\Types;

class CommentDataMapping
{
    public const COMMENT_ID = 'comment_id';
    public const ISSUE_ID = 'issue_id';
    public const USER_ID = 'user_id';
    public const USERNAME = UserTableAdapter::USERNAME;
    public const CONTENT = 'content';
    public const AVATAR_URL = UserTableAdapter::AVATAR_URL;

    private const TYPES = [
        self::COMMENT_ID => Types::INTEGER,
        self::ISSUE_ID => Types::INTEGER,
        self::USER_ID => Types::INTEGER,
        self::CONTENT => Types::STRING,
        self::USERNAME => Types::STRING,
        self::AVATAR_URL => Types::STRING
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