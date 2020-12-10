<?php

namespace App\Module\Issue\Domain\Model;

class IssueFieldType
{
    public const STRING = 0;
    public const TIME_INTERVAL = 1;

    public static function getTypes(): array
    {
        return [
            self::STRING,
            self::TIME_INTERVAL
        ];
    }
}