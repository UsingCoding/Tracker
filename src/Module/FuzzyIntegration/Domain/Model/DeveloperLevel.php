<?php

namespace App\Module\FuzzyIntegration\Domain\Model;

use App\Common\Domain\Utils\Arrays;

class DeveloperLevel
{
    public const JUNIOR = 0;
    public const MIDDLE = 1;
    public const SENIOR = 2;
    public const ARCHITECT = 3;

    public static function getRanges(): array
    {
        return [
            self::JUNIOR => Arrays::range(0, 4),
            self::MIDDLE => Arrays::range(3, 7),
            self::SENIOR => Arrays::range(6, 9),
            self::ARCHITECT => Arrays::range(8, 10),
        ];
    }
}