<?php

namespace App\Module\Issue\Domain\Service;

use App\Common\Domain\Utils\Strings;
use App\Module\Issue\Domain\Exception\InvalidIssueCodeException;
use App\Module\Issue\Domain\Model\IssueCode;

class IssueCodeService
{
    public const CODE_SEPARATOR = '-';

    /**
     * @param string $code
     * @return IssueCode
     * @throws InvalidIssueCodeException
     */
    public static function splitCode(string $code): IssueCode
    {
        $parts = Strings::split($code, self::CODE_SEPARATOR);

        if (count($parts) !== 2 || !is_string($parts[0]) || !ctype_digit($parts[1]))
        {
            throw new InvalidIssueCodeException();
        }

        return new IssueCode($parts[0], $parts[1]);
    }

    public static function getCode(string $projectNameId, int $issueId): string
    {
        return $projectNameId . '-' . $issueId;
    }
}