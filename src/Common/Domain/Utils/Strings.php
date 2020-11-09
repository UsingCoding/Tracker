<?php

namespace App\Common\Domain\Utils;

class Strings
{
    public static function isStartsWith(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle) === 0;
    }
}