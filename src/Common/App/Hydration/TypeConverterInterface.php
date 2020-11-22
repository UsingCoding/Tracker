<?php

namespace App\Common\App\Hydration;

interface TypeConverterInterface
{
    /**
     * @param string $type
     * @param mixed $value
     * @return mixed
     */
    public function convert(string $type, $value);
}