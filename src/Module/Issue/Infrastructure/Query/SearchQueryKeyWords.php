<?php

namespace App\Module\Issue\Infrastructure\Query;

use App\Common\Domain\Utils\Arrays;
use App\Module\Issue\Infrastructure\Adapter\UserTableAdapter;

class SearchQueryKeyWords
{
    public const ASSIGNEE = 'assignee';
    public const GROUP_BY = 'group by';
    public const ORDER_BY = 'order-by';

    public const MODIFICATION_KEY_WORDS = [
        self::GROUP_BY
    ];

    private const KEY_WORDS_TABLE_COLUMN_NAME_MAP = [
        self::ASSIGNEE => UserTableAdapter::USERNAME
    ];

    private const AVAILABLE_FOR_SEARCH_TABLES = [

    ];

    public static function getMappedNameByKeyWord(string $rawKeyWord): string
    {
        return Arrays::get(self::KEY_WORDS_TABLE_COLUMN_NAME_MAP, $rawKeyWord, $rawKeyWord);
    }

    public static function hasColumn(string $columnName): bool
    {

    }
}