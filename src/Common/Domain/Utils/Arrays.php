<?php

namespace App\Common\Domain\Utils;

class Arrays
{
    public static function get(array $collection, $key, $defaultValue = null)
    {
        return $collection[$key] ?? $defaultValue;
    }
}