<?php

namespace App\Common\Domain\Utils;

class Reflection
{
    public static function getFunctionArgumentsCount(callable $fn): int
    {
        try
        {
            return (new \ReflectionFunction($fn))->getNumberOfParameters();
        }
        catch (\ReflectionException $exception)
        {
            return 0;
        }
    }
}