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
}