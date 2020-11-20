<?php

namespace App\Framework\Infrastructure\Hydration;

use App\Common\App\Hydration\TypeConverterInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DbalTypeConverter implements TypeConverterInterface
{
    private const SIMPLE_ARRAY_TYPE = 'simple_array';

    private AbstractPlatform $platform;

    public function __construct(AbstractPlatform $platform)
    {
        $this->platform = $platform;
    }

    /**
     * @param string $type
     * @param mixed $value
     * @return array|mixed
     * @throws \Doctrine\DBAL\Exception
     */
    public function convert(string $type, $value)
    {
        if ($type === self::SIMPLE_ARRAY_TYPE && $value === '')
        {
            return [];
        }

        return Type::getType($type)->convertToPHPValue($value, $this->platform);
    }
}