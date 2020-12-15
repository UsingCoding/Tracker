<?php

namespace App\Module\FuzzyIntegration\Domain\Model;

use App\Common\Domain\Utils\Arrays;

class IssueDifficulty
{
    public const EASY = 1;
    public const MEDIUM = 2;
    public const HARD = 3;

    public static function getRanges(): array
    {
        return [
            self::EASY => Arrays::range(0, 4),
            self::MEDIUM => Arrays::range(4, 8),
            self::HARD => Arrays::range(7, 10),
        ];
    }
}