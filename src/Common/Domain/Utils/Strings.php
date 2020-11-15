<?php

namespace App\Common\Domain\Utils;

class Strings
{
    public static function isStartsWith(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle) === 0;
    }

    public static function contains(string $haystack, string $needle): bool
    {
        return str_contains($haystack, $needle);
    }

    public static function isEndsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);

        if($length === 0)
        {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }

    public static function trim(string $value): string
    {
        return trim($value);
    }
}