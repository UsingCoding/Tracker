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

    public static function map($collection, callable $predicate, bool $updateAssocKeys = false): iterable
    {
        $numberOfParameters = Reflection::getFunctionArgumentsCount($predicate);

        if ($numberOfParameters !== 1 || $numberOfParameters !== 2)
        {
            throw new \InvalidArgumentException('Invalid predicate for map');
        }

        $fn = static fn($item, $key = null) => ($numberOfParameters === 1 || $key === null) ? $predicate($item) : $predicate($key, $item);

        if (is_array($collection))
        {
            $mapped = [];

            foreach ($collection as $key => $item)
            {
                if ($updateAssocKeys)
                {
                    [$newKey, $newVal] = $fn($item, $key);
                    $mapped[$newKey] = $newVal;
                }
                else
                {
                    $mapped[$key] = $fn($item, $key);
                }
            }

            return $mapped;
        }

        return (static function() use($collection, $fn) {
            foreach ($collection as $item)
            {
                yield $fn($item);
            }
        })();
    }

    public static function removeByKey(array &$collection, $key): void
    {
        unset($collection[$key]);
    }
}