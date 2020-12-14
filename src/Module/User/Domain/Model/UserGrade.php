<?php

namespace App\Module\User\Domain\Model;

use App\Common\Domain\Utils\Arrays;

class UserGrade
{
    public const JUNIOR = 0;
    public const MIDDLE = 1;
    public const SENIOR = 2;
    public const ARCHITECT = 3;

    private const GRADES_LIST = [
        self::JUNIOR,
        self::MIDDLE,
        self::SENIOR,
        self::ARCHITECT
    ];

    public static function exists(int $grade): bool
    {
        return Arrays::hasValue(self::GRADES_LIST, $grade);
    }
}