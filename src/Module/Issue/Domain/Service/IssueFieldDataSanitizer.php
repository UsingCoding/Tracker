<?php

namespace App\Module\Issue\Domain\Service;

use App\Common\Domain\Utils\Strings;
use App\Module\Issue\Domain\Exception\InvalidIssueFieldDataException;

class IssueFieldDataSanitizer
{
    private const NAME_MAX_LENGTH = 20;

    /**
     * @param string $rawName
     * @return string
     * @throws InvalidIssueFieldDataException
     */
    public static function sanitizeName(string $rawName): string
    {
        $name = Strings::trim($rawName);

        $nameLength = Strings::length($name);

        $nameMaxLength = self::NAME_MAX_LENGTH;

        if ($nameLength === 0 || $nameLength > $nameMaxLength)
        {
            throw new InvalidIssueFieldDataException("Issue field name must have length from 1 to {$nameMaxLength}");
        }

        return $name;
    }
}