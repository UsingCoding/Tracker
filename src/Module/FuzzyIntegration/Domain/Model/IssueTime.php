<?php

namespace App\Module\FuzzyIntegration\Domain\Model;

use App\Common\Domain\Utils\Arrays;

class IssueTime
{
    public const VERY_URGENT = 0;
    public const URGENT = 1;
    public const REGULAR = 2;
    public const LONG = 3;
    public const VERY_LONG = 4;

    public static function getRanges(): array
    {
        return [
            self::VERY_URGENT => Arrays::range(0, 3),
            self::URGENT => Arrays::range(2, 6),
            self::REGULAR => Arrays::range(4, 10),
            self::LONG => Arrays::range(8, 32),
            self::VERY_LONG => Arrays::range(29, 56)
        ];
    }
}