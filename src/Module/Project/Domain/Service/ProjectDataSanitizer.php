<?php

namespace App\Module\Project\Domain\Service;

use App\Common\Domain\Utils\Strings;
use App\Module\Project\Domain\Exception\InvalidProjectDataException;

class ProjectDataSanitizer
{
    private const NAME_MAX_LENGTH = 50;
    private const NAME_ID_MAX_LENGTH = 10;
    private const DESCRIPTION_MAX_LENGTH = 255;

    /**
     * @param string $rawName
     * @return string
     * @throws InvalidProjectDataException
     */
    public static function sanitizeName(string $rawName): string
    {
        $name = Strings::trim($rawName);

        $nameLength = Strings::length($name);

        $nameMaxLength = self::DESCRIPTION_MAX_LENGTH;
        if ($nameLength === 0 || $nameLength > $nameMaxLength)
        {
            throw new InvalidProjectDataException("Name must have length from 1 to {$nameMaxLength}");
        }

        return $name;
    }

    /**
     * @param string $rawNameId
     * @return string
     * @throws InvalidProjectDataException
     */
    public static function sanitizeNameId(string $rawNameId): string
    {
        $nameId = Strings::trim($rawNameId);

        $nameIdLength = Strings::length($nameId);

        $nameIdMaxLength = self::DESCRIPTION_MAX_LENGTH;
        if ($nameIdLength === 0 || $nameIdLength > $nameIdMaxLength)
        {
            throw new InvalidProjectDataException("NameId must have length from 1 to {$nameIdMaxLength}");
        }

        return $nameId;
    }

    /**
     * @param string $rawDescription
     * @return string
     * @throws InvalidProjectDataException
     */
    public static function sanitizeDescription(string $rawDescription): string
    {
        $description = Strings::trim($rawDescription);

        $descriptionLength = Strings::length($description);

        $descriptionMaxLength = self::DESCRIPTION_MAX_LENGTH;
        if ($descriptionLength === 0 || $descriptionLength > $descriptionMaxLength)
        {
            throw new InvalidProjectDataException("Description must have length from 1 to {$descriptionMaxLength}");
        }

        return $description;
    }
}