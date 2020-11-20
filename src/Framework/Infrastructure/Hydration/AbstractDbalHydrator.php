<?php


namespace App\Framework\Infrastructure\Hydration;


use App\Common\App\Hydration\HydratorInterface;
use App\Common\App\Hydration\TypeConverterInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class AbstractDbalHydrator implements HydratorInterface
{
    private TypeConverterInterface $typeConverter;

    public function __construct(AbstractPlatform $platform)
    {
        $this->typeConverter = new DbalTypeConverter($platform);
    }

    public function hydrateAll(array $rows): array
    {
        $results = [];

        foreach ($rows as $row)
        {
            $this->hydrate($row, $results);
        }

        return $results;
    }

    abstract protected function getColumnType(string $columnName): string;

    /**
     * @param string $columnName
     * @param array $row
     * @return array|mixed
     * @throws \Doctrine\DBAL\Exception
     */
    protected function convertValue(string $columnName, array $row)
    {
        return $this->typeConverter->convert($this->getColumnType($columnName), $row[$columnName]);
    }
}