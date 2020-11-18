<?php

namespace App\Common\Domain\Utils;

class Arrays
{
    public static function get(array $collection, $key, $defaultValue = null)
    {
        return $collection[$key] ?? $defaultValue;
    }

    public static function merge(array ...$arrays): array
    {
        $res = [];

        foreach ($arrays as $array)
        {
            foreach ($array as $key => $value)
            {
                $res[$key] = $value;
            }
        }

        return $res;
    }

    public static function hasKey(array $collection, $key): bool
    {
        return array_key_exists($key, $collection);
    }

    public static function hasValue(array $collection, $value): bool
    {
        return in_array($value, $collection, true);
    }
}