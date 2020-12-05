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

    /**
     * @param iterable $collection
     * @param callable $predicate
     * @param bool $returnWithKey
     * @return mixed|null
     */
    public static function findIf(iterable $collection, callable $predicate, bool $returnWithKey = false)
    {
        $numberOfParameters = Reflection::getFunctionArgumentsCount($predicate);

        if ($numberOfParameters !== 1 && $numberOfParameters !== 2)
        {
            throw new \InvalidArgumentException('Invalid predicate for map');
        }

        $fn = static fn($item, $key = null) => ($numberOfParameters === 1 || $key === null) ? $predicate($item) : $predicate($key, $item);

        foreach ($collection as $key => $item)
        {
            if ($fn($item, $key))
            {
                return !$returnWithKey ? $item : [$key, $item];
            }
        }

        return null;
    }

    /**
     * @param array|iterable $collection
     * @param callable $predicate
     * @param bool $updateAssocKeys
     * @return iterable
     */
    public static function map($collection, callable $predicate, bool $updateAssocKeys = false): iterable
    {
        $numberOfParameters = Reflection::getFunctionArgumentsCount($predicate);

        if ($numberOfParameters !== 1 && $numberOfParameters !== 2)
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

    public static function length(array $collection): int
    {
        return count($collection);
    }

    /**
     * @param string|int|float $start
     * @param string|int|float $end
     * @param int|float $step
     * @return array
     */
    public static function range($start, $end, $step = 1): array
    {
        return range($start, $end, $step);
    }

    public static function removeNulls(iterable $collection): iterable
    {
        if (is_array($collection))
        {
            $filtered = [];
            foreach ($collection as $key => $item)
            {
                if ($item !== null)
                {
                    $filtered[$key] = $item;
                }
            }

            return $filtered;
        }

        return (static function() use($collection) {
            foreach ($collection as $item)
            {
                if ($item !== null)
                {
                    yield $item;
                }
            }
        })();
    }

    public static function between(array $range, $value): bool
    {
        $rangeLength = self::length($range);
        if ($rangeLength < 2)
        {
            throw new \InvalidArgumentException('Incorrect length for between check');
        }

        return $range[0] > $value && $value < $range[$rangeLength - 1];
    }
}